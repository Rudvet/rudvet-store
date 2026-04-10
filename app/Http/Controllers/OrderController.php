<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (!session('user_id')) return redirect()->route('login');
        $orders = Order::where('user_id', session('user_id'))->orderBy('created_at', 'desc')->get();
        return view('shop.orders', compact('orders'));
    }

    public function show($id)
    {
        if (!session('user_id')) return redirect()->route('login');
        $order = Order::with('items.product')->where('user_id', session('user_id'))->findOrFail($id);
        return view('shop.order-detail', compact('order'));
    }
}