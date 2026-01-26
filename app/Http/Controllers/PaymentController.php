<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('user.dashboard')->with('info', 'Order already processed.');
        }

        return view('user.payment.show', compact('order'));
    }

    public function process(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Simulate Payment Success
        $order->update(['status' => 'paid']);

        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'payment_method' => 'manual_transfer', // Dummy
            'status' => 'success',
            'transaction_id' => 'TRX-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Payment successful! Order #' . $order->id . ' is confirmed.');
    }
}
