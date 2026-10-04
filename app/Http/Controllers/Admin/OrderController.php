<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,shipped,completed,cancelled'],
            'shipping_courier' => ['nullable', 'string', 'max:100'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'cancellation_reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $order->update([
            'status' => $data['status'],
            'shipping_courier' => $data['shipping_courier'] ?? $order->shipping_courier,
            'tracking_number' => $data['tracking_number'] ?? $order->tracking_number,
            'cancellation_reason' => $data['cancellation_reason'] ?? $order->cancellation_reason,
        ]);

        if ($data['status'] === 'shipped' && ! $order->shipped_at) {
            $order->update(['shipped_at' => now()]);
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function confirmPayment(Order $order)
    {
        abort_if($order->payment_status === 'paid', 422);

        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        if ($order->status === 'pending') {
            $order->update(['status' => 'confirmed']);
        }

        return back()->with('success', 'Pembayaran dikonfirmasi.');
    }
}