@extends('layouts.app')
@section('title', 'Заказ оформлен — RudvetStore')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">
    <!-- анимация успеха -->
    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h1 class="text-4xl font-black text-gray-800 mb-3">Заказ оплачен! 🎉</h1>
    <p class="text-gray-500 text-lg mb-2">Заказ <span class="font-bold text-purple-600">#{{ $order->id }}</span> успешно оформлен</p>
    <p class="text-gray-400 mb-8">Мы отправили подтверждение на {{ $order->email }}</p>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-left mb-8">
        <h2 class="font-bold text-gray-800 mb-4">Детали заказа</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ $item->product?->image_url ?: 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-lg object-cover">
                    <div>
                        <div class="font-medium text-gray-800 text-sm">{{ $item->product_name }}</div>
                        <div class="text-xs text-gray-400">{{ $item->quantity }} шт.</div>
                    </div>
                </div>
                <span class="font-bold text-gray-800">{{ number_format($item->subtotal, 0, '.', ' ') }} ₽</span>
            </div>
            @endforeach
            <div class="border-t pt-3 flex justify-between font-black text-lg">
                <span>Итого оплачено:</span>
                <span class="gradient-text">{{ number_format($order->total, 0, '.', ' ') }} ₽</span>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('orders.index') }}" class="px-6 py-3 gradient-bg text-white rounded-xl font-bold hover:opacity-90 transition-all">Мои заказы</a>
        <a href="{{ route('catalog') }}" class="px-6 py-3 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-colors">Продолжить покупки</a>
    </div>
</div>
@endsection
