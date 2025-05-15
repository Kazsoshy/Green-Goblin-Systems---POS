<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['items', 'payments'])
            ->latest()
            ->paginate(10);
            
        return view('cashier.sales.index', compact('sales'));
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
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card'
        ]);

        try {
            DB::beginTransaction();

            // Create sale
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_amount' => 0, // Will be calculated
                'sale_date' => now(),
                'payment_method' => $request->payment_method,
                'receipt_number' => 'RCP-' . strtoupper(Str::random(10)),
                'status' => 'completed'
            ]);

            $totalAmount = 0;

            // Process each item
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Validate stock
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                // Create sale item
                $saleItem = SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'discount' => $item['discount'] ?? 0
                ]);

                // Update stock
                $product->decrement('stock_quantity', $item['quantity']);

                // Add to total
                $totalAmount += ($product->price * $item['quantity']) - ($item['discount'] ?? 0);
            }

            // Update sale total
            $sale->update(['total_amount' => $totalAmount]);

            // Create payment record
            Payment::create([
                'sale_id' => $sale->id,
                'amount' => $totalAmount,
                'status' => 'completed',
                'payment_date' => now(),
                'reference_number' => 'PAY-' . strtoupper(Str::random(10))
            ]);

            DB::commit();

            // Clear the cart after successful purchase
            session()->forget('cart');

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'message' => 'Sale completed successfully',
                'redirect_url' => route('sales.success', $sale->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'payments', 'refunds']);
        return view('cashier.sales.show', compact('sale'));
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