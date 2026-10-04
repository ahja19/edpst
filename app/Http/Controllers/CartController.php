<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::where('user_id', auth()->id())
            ->whereHas('product')
            ->get();

        return view('cart', compact('items'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = min($request->quantity, $product->stock);

        if ($quantity < 1) {
            return back()->with('error', 'Stok produk tidak tersedia.');
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['quantity' => 0]
        );

        $cart->quantity = min($cart->quantity + $quantity, $product->stock);
        $cart->save();

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        $this->abortCart($cart);

        abort_unless($cart->product()->exists(), 404);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart->quantity = min($request->quantity, $cart->product->stock);
        $cart->save();

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        $this->abortCart($cart);
        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    private function abortCart(Cart $cart)
    {
        abort_unless($cart->user_id === auth()->id(), 403);
    }
}