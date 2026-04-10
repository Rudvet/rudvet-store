@extends('layouts.app')
@section('title', 'Каталог — RudvetStore')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:py-8">
    <!-- Кнопка фильтров для мобильных -->
    <div class="lg:hidden mb-4">
        <button id="toggleFiltersBtn" class="w-full flex items-center justify-center space-x-2 gradient-bg text-white px-4 py-3 rounded-xl font-semibold hover:opacity-90 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span>Фильтры и сортировка</span>
            <svg id="filtersArrow" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
        <!-- Фильтры (скрыто на мобильных по умолчанию) -->
        <aside id="filtersSidebar" class="lg:w-72 flex-shrink-0 hidden lg:block transition-all duration-300">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 sticky top-20">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-bold text-gray-800 text-lg">Фильтры</h2>
                    <a href="{{ route('catalog') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Сбросить все</a>
                </div>
                <form action="{{ route('catalog') }}" method="GET" id="filterForm">
                    <!-- Категории -->
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">Категория</h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded-lg transition-colors">
                                <input type="radio" name="category" value="" {{ !$selectedCategory ? 'checked' : '' }} class="text-purple-600 w-4 h-4" onchange="document.getElementById('filterForm').submit()">
                                <span class="text-sm text-gray-600">Все категории</span>
                            </label>
                            @foreach($categories as $cat)
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded-lg transition-colors">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ $selectedCategory === $cat->slug ? 'checked' : '' }} class="text-purple-600 w-4 h-4" onchange="document.getElementById('filterForm').submit()">
                                <span class="text-sm text-gray-600">{{ $cat->icon }} {{ $cat->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Цена -->
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">Цена (₽)</h3>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="от" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="до" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>
                    </div>
                    
                    <!-- Бренд -->
                    @if($brands->count())
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">Бренд</h3>
                        <div class="space-y-2 max-h-32 overflow-y-auto pr-2">
                            @foreach($brands as $brand)
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded-lg transition-colors">
                                <input type="radio" name="brand" value="{{ $brand }}" {{ request('brand') === $brand ? 'checked' : '' }} class="text-purple-600 w-4 h-4" onchange="document.getElementById('filterForm').submit()">
                                <span class="text-sm text-gray-600">{{ $brand }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Сортировка -->
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">Сортировка</h3>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 bg-white" onchange="document.getElementById('filterForm').submit()">
                            <option value="new" {{ request('sort') === 'new' ? 'selected' : '' }}>🆕 Новинки</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>💰 Цена: по возрастанию</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>💰 Цена: по убыванию</option>
                        </select>
                    </div>
                    
                    <div class="flex gap-2 mt-6">
                        <button type="submit" class="flex-1 py-2.5 gradient-bg text-white rounded-xl font-semibold hover:opacity-90 transition-all text-sm">Применить</button>
                        <a href="{{ route('catalog') }}" class="flex-1 py-2.5 text-center border border-gray-200 text-gray-600 rounded-xl font-medium hover:bg-gray-50 transition-all text-sm">Сбросить</a>
                    </div>
                </form>
            </div>
        </aside>

        <main class="flex-1">
            <!-- Заголовок с количеством и сортировкой для компа -->
            <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-3">
                <h1 class="text-xl sm:text-2xl font-black text-gray-800">
                    Каталог товаров 
                    <span class="text-gray-400 text-base sm:text-xl font-normal">({{ $products->total() }})</span>
                </h1>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>🔍</span>
                    <span>Найдено: {{ $products->count() }} товаров</span>
                </div>
            </div>
            
            @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
                @foreach($products as $product)
                @include('shop.partials.product-card')
                @endforeach
            </div>
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-16 sm:py-20">
                <div class="text-5xl sm:text-6xl mb-4">🔍</div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-700 mb-2">Товары не найдены</h3>
                <p class="text-gray-500 mb-6 text-sm sm:text-base">Попробуйте изменить фильтры или сбросить их</p>
                <a href="{{ route('catalog') }}" class="inline-block px-6 py-3 gradient-bg text-white rounded-xl font-semibold hover:opacity-90 transition-all">Сбросить фильтры</a>
            </div>
            @endif
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleFiltersBtn');
    const filtersSidebar = document.getElementById('filtersSidebar');
    const filtersArrow = document.getElementById('filtersArrow');
    
    if (toggleBtn && filtersSidebar) {
        toggleBtn.addEventListener('click', function() {
            if (filtersSidebar.classList.contains('hidden')) {
                filtersSidebar.classList.remove('hidden');
                filtersSidebar.classList.add('block');
                if (filtersArrow) filtersArrow.style.transform = 'rotate(180deg)';
            } else {
                filtersSidebar.classList.remove('block');
                filtersSidebar.classList.add('hidden');
                if (filtersArrow) filtersArrow.style.transform = 'rotate(0deg)';
            }
        });
    }
    
    // Автоматическая отправка формы 
    const radios = document.querySelectorAll('#filterForm input[type="radio"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
});
</script>

<style>
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.pagination .page-item {
    display: inline-block;
}
.pagination .page-link {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    color: #4b5563;
    background-color: white;
    transition: all 0.2s ease;
}
.pagination .page-link:hover {
    background-color: #f3f4f6;
    border-color: #d1d5db;
}
.pagination .active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: white;
}
.pagination .disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endsection