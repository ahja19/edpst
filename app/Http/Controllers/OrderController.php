<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('orders.show', compact('order'));
    }

    public function payment(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('orders.payment', compact('order'));
    }

    public function uploadPayment(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_if($order->payment_status === 'paid', 422);

        $data = $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payments', 'public');

        $order->update([
            'payment_proof' => $path,
            'payment_status' => 'pending',
        ]);

        return back()->with('success', 'Bukti pembayaran terkirim. Menunggu verifikasi admin.');
    }
}