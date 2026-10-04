<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create()
    {
        $items = Cart::where('user_id', auth()->id())
            ->whereHas('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $total = $items->sum(fn ($item) => $item->product->price * $item->quantity);

        return view('checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $items = Cart::where('user_id', auth()->id())
            ->whereHas('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        try {
            $orderId = null;

            DB::transaction(function () use ($items, $data, &$orderId) {
                $total = 0;

                foreach ($items as $item) {
                    $product = $item->product;

                    if ($product->stock < $item->quantity) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi.");
                    }

                    $total += $product->price * $item->quantity;
                }

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'PRF-'.strtoupper(uniqid()),
                    'customer_name' => $data['name'],
                    'customer_email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'status' => 'pending',
                    'total' => $total,
                ]);

                foreach ($items as $item) {
                    $product = $item->product;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $item->quantity,
                    ]);

                    $product->decrement('stock', $item->quantity);
                    $item->delete();
                }

                session(['order_id' => $order->id]);
                $orderId = $order->id;
            });

            return redirect()->route('orders.payment', $orderId);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        $orderId = session()->pull('order_id');
        $order = $orderId ? Order::find($orderId) : null;

        if (!$order) {
            return redirect()->route('shop.index');
        }

        return view('order-success', compact('order'));
    }
}