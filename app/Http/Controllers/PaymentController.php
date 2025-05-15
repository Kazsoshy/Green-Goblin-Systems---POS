<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card'
        ]);

        try {
            DB::beginTransaction();

            $sale = Sale::findOrFail($request->sale_id);
            
            // Calculate total paid amount including this payment
            $totalPaid = $sale->payments()->sum('amount') + $request->amount;
            
            // Validate payment amount
            if ($totalPaid > $sale->total_amount) {
                throw new \Exception('Payment amount exceeds sale total');
            }

            // Create payment
            $payment = Payment::create([
                'sale_id' => $sale->id,
                'amount' => $request->amount,
                'status' => 'completed',
                'payment_date' => now(),
                'reference_number' => 'PAY-' . strtoupper(Str::random(10))
            ]);

            // Update sale status if fully paid
            if ($totalPaid == $sale->total_amount) {
                $sale->update(['status' => 'completed']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'payment' => $payment,
                'message' => 'Payment processed successfully'
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
    public function show(Payment $payment)
    {
        $payment->load('sale');
        return view('cashier.payments.show', compact('payment'));
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
}
