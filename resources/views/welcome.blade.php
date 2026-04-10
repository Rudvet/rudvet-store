@extends('layouts.app')
@section('content')
@php
    $featuredProducts = collect();
    $newProducts = collect();
    $categories = collect();
    $stats = ['products' => 0, 'categories' => 0, 'brands' => 0];
    try {
        $featuredProducts = \App\Models\Product::where('active', true)->where('featured', true)->with('category')->take(8)->get();
        $newProducts = \App\Models\Product::where('active', true)->with('category')->orderBy('created_at', 'desc')->take(8)->get();
        $categories = \App\Models\Category::withCount('products')->get();
        $stats = ['products' => \App\Models\Product::where('active', true)->count(), 'categories' => \App\Models\Category::count(), 'brands' => \App\Models\Product::where('active', true)->distinct('brand')->count('brand')];
    } catch (\Exception $e) {}
@endphp

<section class="relative overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 md:py-32">
        <div class="max-w-3xl">
            <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm mb-6">
                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                <span>{{ $stats['products'] }}+ товаров в наличии</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-6">Мир <span class="text-yellow-400">технологий</span><br>у ваших рук</h1>
            <p class="text-xl text-white/80 mb-10">Смартфоны, ноутбуки, планшеты и аксессуары от ведущих мировых брендов.</p>
            <a href="{{ route('catalog') }}" class="inline-flex items-center space-x-2 px-8 py-4 bg-white text-purple-700 font-bold rounded-2xl hover:bg-yellow-400 hover:text-black transition-all duration-300">
                <span>Перейти в каталог</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

@if($categories->count())
<section class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-black text-gray-800 text-center mb-10">Категории</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categories as $cat)
        <a href="{{ route('catalog') }}?category={{ $cat->slug }}" class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
            <div class="text-4xl mb-2">{{ $cat->icon }}</div>
            <div class="font-bold text-gray-800 text-sm">{{ $cat->name }}</div>
        </a>
        @endforeach
    </div>
</section>
@endif

@if($newProducts->count())
<section class="max-w-7xl mx-auto px-4 pb-16">
    <h2 class="text-3xl font-black text-gray-800 mb-8">Новинки</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($newProducts as $product)
        @include('shop.partials.product-card')
        @endforeach
    </div>
</section>
@endif
@endsection
