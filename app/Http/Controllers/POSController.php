<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('pos.index', compact('products'));
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
                'user_id' => auth()->id(),
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
} 