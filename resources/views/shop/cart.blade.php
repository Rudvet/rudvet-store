@extends('layouts.app')
@section('title', 'Корзина — RudvetStore')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-black text-gray-800 mb-8">🛒 Корзина</h1>

    @if(count($cartItems) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center space-x-4">
                <img src="{{ $item['product']->image_url ?: 'https://via.placeholder.com/80' }}" alt="" class="w-20 h-20 object-cover rounded-xl">
                <div class="flex-1">
                    <a href="{{ route('product.show', $item['product']->id) }}" class="font-bold text-gray-800 hover:text-purple-600 transition-colors">{{ $item['product']->name }}</a>
                    <div class="text-sm text-gray-400">{{ $item['product']->brand }}</div>
                    <div class="text-lg font-black text-purple-600 mt-1">{{ number_format($item['product']->price, 0, '.', ' ') }} ₽</div>
                </div>
                <div class="flex items-center space-x-3">
                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-3 py-2 hover:bg-gray-100 text-gray-600">−</button>
                        <span class="px-3 py-2 text-sm font-bold">{{ $item['quantity'] }}</span>
                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 py-2 hover:bg-gray-100 text-gray-600">+</button>
                    </form>
                    <span class="font-bold text-gray-800 w-28 text-right">{{ number_format($item['subtotal'], 0, '.', ' ') }} ₽</span>
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                        <button type="submit" class="text-red-400 hover:text-red-600 p-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

            <form action="{{ route('cart.clear') }}" method="POST" class="flex justify-end">
                @csrf
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition-colors">Очистить корзину</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit sticky top-20">
            <h2 class="font-bold text-gray-800 text-lg mb-5">Итого</h2>
            <div class="space-y-3 mb-6">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Товаров:</span>
                    <span>{{ array_sum(array_column($cartItems, 'quantity')) }} шт.</span>
                </div>
                <div class="flex justify-between font-black text-xl">
                    <span>Итого:</span>
                    <span class="gradient-text">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                </div>
            </div>
            <a href="{{ route('checkout.index') }}" class="block w-full text-center btn-primary text-white py-4 rounded-xl font-bold hover:shadow-lg transition-all">Оформить заказ →</a>
            <a href="{{ route('catalog') }}" class="block w-full text-center mt-3 py-3 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors text-sm">Продолжить покупки</a>
        </div>
    </div>
    @else
    <div class="text-center py-20">
        <div class="text-8xl mb-6">🛒</div>
        <h2 class="text-2xl font-bold text-gray-700 mb-3">Корзина пуста</h2>
        <p class="text-gray-500 mb-8">Добавьте товары из каталога</p>
        <a href="{{ route('catalog') }}" class="inline-flex items-center space-x-2 px-8 py-4 btn-primary text-white rounded-2xl font-bold">
            <span>Перейти в каталог</span>
        </a>
    </div>
    @endif
</div>
@endsection
