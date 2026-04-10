<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!session('user_id')) return redirect()->route('login')->with('error', 'Войдите для оформления заказа');
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $cartItems = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                $cartItems[] = ['product' => $product, 'quantity' => $item['quantity'], 'subtotal' => $subtotal];
            }
        }
        return view('shop.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        if (!session('user_id')) return redirect()->route('login');

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
        ], [
            'first_name.required' => 'Имя обязательно',
            'last_name.required' => 'Фамилия обязательна',
            'email.required' => 'Email обязателен',
            'phone.required' => 'Телефон обязателен',
            'address.required' => 'Адрес обязателен',
            'city.required' => 'Город обязателен',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $total = 0;
        $items = [];
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $total += $product->price * $item['quantity'];
                $items[] = ['product' => $product, 'quantity' => $item['quantity']];
            }
        }

        $order = Order::create([
            'user_id' => session('user_id'),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'price' => $item['product']->price,
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('checkout.payment', $order->id);
    }

    public function payment($orderId)
    {
        if (!session('user_id')) return redirect()->route('login');
        $order = Order::with('items')->findOrFail($orderId);
        return view('shop.payment', compact('order'));
    }

    public function processPayment(Request $request, $orderId)
    {
        if (!session('user_id')) return redirect()->route('login');

        $request->validate([
            'card_number' => 'required|string|min:16|max:19',
            'card_name' => 'required|string',
            'card_expiry' => 'required|string',
            'card_cvv' => 'required|string|min:3|max:4',
        ], [
            'card_number.required' => 'Номер карты обязателен',
            'card_name.required' => 'Имя на карте обязательно',
            'card_expiry.required' => 'Срок действия обязателен',
            'card_cvv.required' => 'CVV обязателен',
        ]);

        $order = Order::findOrFail($orderId);
        // Payment emulation - always succeeds
        $order->update(['payment_status' => 'paid', 'status' => 'processing']);

        return redirect()->route('checkout.success', $orderId);
    }

    public function success($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('shop.success', compact('order'));
    }
}