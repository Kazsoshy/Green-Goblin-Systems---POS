<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Sale $sale)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Check if sale is eligible for refund
            if ($sale->status !== 'completed') {
                throw new \Exception('Only completed sales can be refunded');
            }

            if ($sale->refunds()->where('status', '!=', 'rejected')->exists()) {
                throw new \Exception('Sale already has a pending or approved refund');
            }

            // Create refund record
            $refund = Refund::create([
                'sale_id' => $sale->id,
                'user_id' => auth()->id(),
                'amount' => $sale->total_amount,
                'reason' => $request->reason,
                'refund_date' => now(),
                'status' => 'pending'
            ]);

            // Update sale status
            $sale->update(['status' => 'refund_pending']);

            DB::commit();

            return response()->json([
                'success' => true,
                'refund' => $refund,
                'message' => 'Refund request submitted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Refund $refund)
    {
        $refund->load(['sale.items.product', 'user']);
        return view('cashier.refunds.show', compact('refund'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve(Refund $refund)
    {
        try {
            DB::beginTransaction();

            if ($refund->status !== 'pending') {
                throw new \Exception('Only pending refunds can be approved');
            }

            // Process refund
            $refund->update([
                'status' => 'approved',
                'refund_date' => now()
            ]);

            // Update sale status
            $refund->sale->update(['status' => 'refunded']);

            // Return items to inventory
            foreach ($refund->sale->items as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Refund approved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function reject(Refund $refund)
    {
        try {
            if ($refund->status !== 'pending') {
                throw new \Exception('Only pending refunds can be rejected');
            }

            $refund->update(['status' => 'rejected']);
            $refund->sale->update(['status' => 'completed']);

            return response()->json([
                'success' => true,
                'message' => 'Refund rejected successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
