<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('shop.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $cart = session('cart', []);
        $id = $request->product_id;
        $qty = $request->quantity ?? 1;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = ['quantity' => $qty];
        }

        session(['cart' => $cart]);
        return response()->json(['success' => true, 'count' => array_sum(array_column($cart, 'quantity'))]);
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $id = $request->product_id;
        if ($request->quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $request->quantity;
        }
        session(['cart' => $cart]);
        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);
        return redirect()->route('cart.index');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index');
    }
}