<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['items', 'payments'])
            ->where('user_id', auth()->id())
            ->latest();

        // Apply filters
        if ($request->filled('search')) {
            $query->where('receipt_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('purchase_type')) {
            $query->where('purchase_type', $request->purchase_type);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $sales = $query->paginate(10);
        return view('user.sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        $categories = \App\Models\Category::all();
        return view('cashier.sales.create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card',
            'purchase_type' => 'required|in:walk-in,delivery',
            'customer_details' => 'required|array',
            'customer_details.name' => 'required|string',
            'customer_details.phone' => 'nullable|string',
            'customer_details.email' => 'nullable|email',
            'customer_details.address' => $request->input('purchase_type') === 'delivery' ? 'required|string' : 'nullable|string',
            'customer_details.notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $cart = Session::get('cart', []);
            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }

            $total = 0;
            $items = [];

            // Validate stock and calculate total
            foreach ($cart as $productId => $details) {
                $product = Product::find($productId);
                if (!$product) {
                    throw new \Exception("Product not found");
                }

                if ($product->stock_quantity < $details['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $subtotal = $product->price * $details['quantity'];
                $total += $subtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $subtotal
                ];
            }

            // Create sale with customer details
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'purchase_type' => $request->purchase_type,
                'status' => 'completed',
                'receipt_number' => 'RCP-' . strtoupper(Str::random(10)),
                'customer_name' => $request->customer_details['name'],
                'customer_phone' => $request->customer_details['phone'],
                'customer_email' => $request->customer_details['email'],
                'customer_address' => $request->customer_details['address'],
                'notes' => $request->customer_details['notes']
            ]);

            // Create sale items and update stock
            foreach ($items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['product']->price,
                    'subtotal' => $item['subtotal'],
                    'discount' => 0
                ]);

                // Update stock
                $item['product']->decrement('stock_quantity', $item['quantity']);
            }

            // Clear cart
            Session::forget('cart');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'redirect_url' => route('user.products.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show(Sale $sale)
    {
        if ($sale->user_id !== auth()->id()) {
            abort(403);
        }
        
        $sale->load(['items.product', 'payments', 'refunds']);
        return view('user.sales.show', compact('sale'));
    }

    public function success(Sale $sale)
    {
        $sale->load(['items.product', 'payments']);
        return view('cashier.sales.success', compact('sale'));
    }

    public function receipt(Sale $sale)
    {
        $sale->load(['items.product', 'payments']);
        return view('cashier.sales.receipt', compact('sale'));
    }
} 