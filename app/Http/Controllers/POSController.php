<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('pos.index', compact('products'));
    }

    public function checkout()
    {
        // We'll pass any data needed for the checkout page
        return view('pos.checkout');
    }

    public function getProduct($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock_quantity,
            'category' => $product->category ? $product->category->name : null
        ]);
    }

    public function processCheckout(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'customer' => 'required|array',
                'customer.name' => 'required|string|max:255',
                'customer.email' => 'nullable|email|max:255',
                'customer.phone' => 'nullable|string|max:20',
                'customer.address' => 'nullable|string',
                'customer.specialNote' => 'nullable|string',
                'customer.paymentMethod' => 'required|in:cash,ewallet,card',
                'items' => 'required|array',
                'items.*.id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'total' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            // Log the request data
            Log::info('Processing checkout with data:', [
                'customer' => $request->customer,
                'items_count' => count($request->items),
                'total' => $request->total
            ]);

            // Calculate the correct total
            $subtotal = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                $subtotal += $product->price * $item['quantity'];
            }
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            // Create a sale record
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer['name'],
                'customer_email' => $request->customer['email'] ?? null,
                'customer_phone' => $request->customer['phone'] ?? null,
                'customer_address' => $request->customer['address'] ?? null,
                'special_note' => $request->customer['specialNote'] ?? null,
                'payment_method' => $request->customer['paymentMethod'],
                'purchase_type' => !empty($request->customer['address']) ? 'delivery' : 'in-store',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total_amount' => $total,
                'status' => 'completed'
            ]);

            // Log the created sale
            Log::info('Sale created:', ['sale_id' => $sale->id]);

            // Check stock availability and create sale items
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }
                
                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity']
                ]);

                // Update stock
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'sale_id' => $sale->id], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error during checkout:', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during checkout:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Check stock availability for all items
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $request->total,
                'status' => 'completed'
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity']
                ]);

                // Update stock
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();
            return response()->json($order, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function transactions()
    {
        // Get the current auth user
        $user = Auth::user();
        
        // Log some debug info
        Log::info('Fetching transactions', [
            'user_id' => Auth::id(),
            'user_exists' => !is_null($user)
        ]);

        // Enable query logging for debugging
        DB::enableQueryLog();
        
        // Get sales from the last 30 days
        $sales = Sale::with('saleItems', 'saleItems.product')
            ->where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Log the result
        Log::info('Transaction query results', [
            'count' => $sales->count(),
            'sql' => DB::getQueryLog()
        ]);
            
        return view('pos.transactions', compact('sales'));
    }

    /**
     * Debug method to see all sales data
     */
    public function debugSales()
    {
        // Get raw sales data
        $allSales = DB::table('sales')->get();
        
        // Check all user IDs with sales
        $userIds = DB::table('sales')->distinct('user_id')->pluck('user_id');
        
        // Get all users
        $users = DB::table('users')->whereIn('id', $userIds)->get();
        
        return response()->json([
            'current_user_id' => Auth::id(),
            'all_sales' => $allSales,
            'user_ids_with_sales' => $userIds,
            'users' => $users
        ]);
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySale($id)
    {
        try {
            DB::beginTransaction();

            // Find the sale
            $sale = Sale::with('saleItems')->findOrFail($id);

            // Check if user is authorized to delete this sale
            if ($sale->user_id != Auth::id()) {
                return redirect()->back()->with('error', 'You are not authorized to delete this transaction.');
            }

            // Restore product inventory for each item
            foreach ($sale->saleItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock_quantity += $item->quantity;
                    $product->save();
                }
            }

            // Delete related sale items first
            SaleItem::where('sale_id', $id)->delete();

            // Then delete the sale
            $sale->delete();

            DB::commit();
            return redirect()->route('pos.transactions')->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting transaction:', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error deleting transaction: ' . $e->getMessage());
        }
    }

    /**
     * Generate a sales report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function salesReport(Request $request)
    {
        // Get filter parameters
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        
        // Add a day to end date to include the full day
        $endDateForQuery = date('Y-m-d', strtotime($endDate . ' +1 day'));

        // Get sales data for the period
        $sales = Sale::with('saleItems', 'saleItems.product')
            ->where('user_id', Auth::id())
            ->whereBetween('created_at', [$startDate, $endDateForQuery])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate totals
        $totalSales = $sales->count();
        $totalRevenue = $sales->sum('total_amount');
        $totalItems = $sales->reduce(function ($carry, $sale) {
            return $carry + $sale->saleItems->sum('quantity');
        }, 0);
        
        // Group by payment method
        $paymentMethodTotals = $sales->groupBy('payment_method')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total' => $group->sum('total_amount')
                ];
            });
        
        // Group by day
        $dailySales = $sales->groupBy(function ($sale) {
            return $sale->created_at->format('Y-m-d');
        })->map(function ($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('total_amount')
            ];
        });

        // Get top selling products
        $topProducts = collect();
        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                if ($item->product) {
                    $productId = $item->product->id;
                    $productName = $item->product->name;
                    
                    if (!$topProducts->has($productId)) {
                        $topProducts->put($productId, [
                            'name' => $productName,
                            'quantity' => 0,
                            'revenue' => 0
                        ]);
                    }
                    
                    $current = $topProducts->get($productId);
                    $current['quantity'] += $item->quantity;
                    $current['revenue'] += $item->quantity * $item->price;
                    $topProducts->put($productId, $current);
                }
            }
        }
        
        // Sort top products by quantity sold
        $topProducts = $topProducts->sortByDesc('quantity')->take(5);
        
        return view('pos.sales-report', compact(
            'sales', 
            'startDate', 
            'endDate', 
            'totalSales', 
            'totalRevenue', 
            'totalItems',
            'paymentMethodTotals',
            'dailySales',
            'topProducts'
        ));
    }
} 