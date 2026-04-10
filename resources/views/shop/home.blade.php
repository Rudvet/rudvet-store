@extends('layouts.app')
@section('title', 'RudvetStore')
@section('content')

<!-- секция -->
<section class="relative overflow-hidden bg-gradient-to-br from-purple-900 via-purple-700 to-indigo-800">
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=1920'); background-size: cover; background-position: center;"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-16 sm:py-20 md:py-28">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs sm:text-sm font-semibold mb-4">
                🔥 Неделя горячих скидок!
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-white leading-tight mb-4">
                Техника, которая
                <span class="block sm:inline">вдохновляет</span>
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto px-4">
                Смартфоны, ноутбуки и гаджеты для вашего комфорта. Быстрая доставка, гарантия качества.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center space-x-2 px-6 sm:px-8 py-3 bg-white text-purple-700 font-bold rounded-xl hover:bg-purple-50 transition-all duration-300 hover:shadow-xl text-sm sm:text-base">
                    <span>В каталог</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- категории -->
<section class="max-w-7xl mx-auto px-4 py-10 sm:py-12 md:py-16">
    <div class="text-center mb-6 sm:mb-8 md:mb-10">
        <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-black text-gray-800 mb-1 sm:mb-2 md:mb-3">Категории товаров</h2>
        <p class="text-xs sm:text-sm text-gray-500">Найдите именно то, что ищете</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2 sm:gap-3 md:gap-4">
        @foreach($categories as $cat)
        <a href="{{ route('catalog') }}?category={{ $cat->slug }}" class="card-hover bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 text-center shadow-sm border border-gray-100 hover:shadow-md transition-all">
            <div class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl mb-1 sm:mb-2 md:mb-3">{{ $cat->icon }}</div>
            <div class="font-bold text-gray-800 text-xs sm:text-sm">{{ $cat->name }}</div>
            <div class="text-gray-400 text-[10px] sm:text-xs mt-0.5 sm:mt-1">{{ $cat->products_count }} товаров</div>
        </a>
        @endforeach
    </div>
</section>

<!-- товары -->
@if($featuredProducts->count())
<section class="bg-gradient-to-br from-purple-50 to-indigo-50 py-10 sm:py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6 sm:mb-8 md:mb-10 gap-3 sm:gap-4">
            <div class="text-center sm:text-left">
                <div class="text-purple-600 font-semibold text-xs sm:text-sm mb-1 sm:mb-2">⭐ Рекомендуем</div>
                <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-black text-gray-800">Хиты продаж</h2>
            </div>
            <a href="{{ route('catalog') }}" class="text-purple-600 font-semibold hover:underline flex items-center space-x-1 text-xs sm:text-sm">
                <span>Все товары</span>
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            @foreach($featuredProducts as $product)
            @include('shop.partials.product-card')
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- новый продукт -->
<section class="max-w-7xl mx-auto px-4 py-10 sm:py-12 md:py-16">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 sm:mb-8 md:mb-10 gap-3 sm:gap-4">
        <div class="text-center sm:text-left">
            <div class="text-green-600 font-semibold text-xs sm:text-sm mb-1 sm:mb-2">🆕 Только что поступили</div>
            <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-black text-gray-800">Новинки</h2>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
        @foreach($newProducts as $product)
        @include('shop.partials.product-card')
        @endforeach
    </div>
</section>

@endsection