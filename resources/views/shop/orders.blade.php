@extends('layouts.app')
@section('title', 'Мои заказы — RudvetStore')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-black text-gray-800 mb-8">Мои заказы</h1>
    @forelse($orders as $order)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <span class="font-bold text-gray-800">Заказ #{{ $order->id }}</span>
                <span class="text-gray-400 text-sm ml-3">{{ $order->created_at->format('d.m.Y H:i') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $order->payment_status === 'paid' ? 'Оплачен' : 'Ожидает оплаты' }}
                </span>
                <span class="px-2 py-1 rounded-lg text-xs font-medium
                    @if($order->status === 'delivered') bg-green-100 text-green-700
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ $order->status_label }}
                </span>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-gray-600 text-sm">{{ $order->city }}, {{ $order->address }}</span>
            <span class="font-black text-xl gradient-text">{{ number_format($order->total, 0, '.', ' ') }} ₽</span>
        </div>
    </div>
    @empty
    <div class="text-center py-20">
        <div class="text-8xl mb-6">📦</div>
        <h2 class="text-2xl font-bold text-gray-700 mb-3">Заказов пока нет</h2>
        <a href="{{ route('catalog') }}" class="inline-block px-8 py-4 btn-primary text-white rounded-2xl font-bold">Начать покупки</a>
    </div>
    @endforelse
</div>
@endsection
