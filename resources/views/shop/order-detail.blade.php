@extends('layouts.app')
@section('title', 'Заказ #{{ $order->id }} — RudvetStore')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('orders.index') }}" class="text-purple-600 hover:underline text-sm">← Мои заказы</a>
    <h1 class="text-3xl font-black text-gray-800 mt-2 mb-8">Заказ #{{ $order->id }}</h1>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b"><tr><th class="px-6 py-3 text-left text-xs font-semibold text-gray-500">Товар</th><th class="px-6 py-3 text-left text-xs font-semibold text-gray-500">Цена</th><th class="px-6 py-3 text-left text-xs font-semibold text-gray-500">Кол-во</th><th class="px-6 py-3 text-right text-xs font-semibold text-gray-500">Итого</th></tr></thead>
            <tbody class="divide-y">
                @foreach($order->items as $item)
                <tr><td class="px-6 py-4"><div class="font-medium text-gray-800">{{ $item->product_name }}</div></td><td class="px-6 py-4 text-gray-600">{{ number_format($item->price, 0, '.', ' ') }} ₽</td><td class="px-6 py-4 text-gray-600">{{ $item->quantity }}</td><td class="px-6 py-4 text-right font-bold">{{ number_format($item->subtotal, 0, '.', ' ') }} ₽</td></tr>
                @endforeach
                <tr class="bg-gray-50"><td colspan="3" class="px-6 py-4 text-right font-bold">Итого:</td><td class="px-6 py-4 text-right font-black text-xl gradient-text">{{ number_format($order->total, 0, '.', ' ') }} ₽</td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
