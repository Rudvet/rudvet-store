@extends('layouts.app')
@section('title', $product->name . ' — RudvetStore')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:py-8">
    <nav class="flex flex-wrap items-center gap-1 text-xs sm:text-sm text-gray-500 mb-4 sm:mb-8">
        <a href="{{ route('home') }}" class="hover:text-purple-600">Главная</a>
        <span>/</span>
        <a href="{{ route('catalog') }}" class="hover:text-purple-600">Каталог</a>
        <span>/</span>
        <a href="{{ route('catalog') }}?category={{ $product->category->slug }}" class="hover:text-purple-600 truncate max-w-[80px] sm:max-w-none">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-gray-800 truncate max-w-[120px] sm:max-w-none">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 md:gap-12 mb-12 sm:mb-16">
        <!-- картинки  -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 shadow-sm border border-gray-100">
            <img src="{{ $product->image_url ?: 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600' }}" alt="{{ $product->name }}" class="w-full h-64 sm:h-80 md:h-96 object-contain product-img">
        </div>

        <!-- детали  -->
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-lg font-medium">{{ $product->category->name }}</span>
                <span class="text-gray-400 text-xs sm:text-sm">{{ $product->brand }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-800 mb-3 sm:mb-4 leading-tight">{{ $product->name }}</h1>

            <div class="flex flex-wrap items-baseline gap-2 sm:gap-4 mb-4 sm:mb-6">
                <span class="text-2xl sm:text-3xl md:text-4xl font-black gradient-text">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                @if($product->old_price)
                <span class="text-base sm:text-lg md:text-xl text-gray-400 line-through">{{ number_format($product->old_price, 0, '.', ' ') }} ₽</span>
                <span class="bg-red-100 text-red-600 text-xs sm:text-sm font-bold px-2 py-1 rounded-lg">-{{ $product->discount_percent }}%</span>
                @endif
            </div>

            <p class="text-sm sm:text-base text-gray-600 leading-relaxed mb-4 sm:mb-6">{{ $product->description }}</p>

            @if($product->specs)
            <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-4 sm:p-5 mb-4 sm:mb-6">
                <h3 class="font-bold text-gray-800 mb-2 sm:mb-3 text-base sm:text-lg">Характеристики</h3>
                <div class="space-y-1.5 sm:space-y-2">
                    @foreach(explode("\n", $product->specs) as $spec)
                    @if(trim($spec))
                    @php $parts = explode(':', $spec, 2); @endphp
                    <div class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-2 text-xs sm:text-sm">
                        <span class="text-gray-500 font-medium min-w-[100px]">{{ trim($parts[0] ?? '') }}</span>
                        <span class="text-gray-800">{{ trim($parts[1] ?? '') }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex items-center space-x-3 mb-6">
    <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
    <span class="text-sm font-medium text-green-700">В наличии</span>
</div>

            @if($product->stock > 0)
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden w-full sm:w-auto">
                    <button type="button" onclick="decrementQuantity()" class="px-3 sm:px-4 py-2.5 sm:py-3 hover:bg-gray-100 text-gray-600 transition-colors text-lg">−</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-14 sm:w-16 py-2.5 sm:py-3 text-center border-x border-gray-200 focus:outline-none text-sm sm:text-base">
                    <button type="button" onclick="incrementQuantity()" class="px-3 sm:px-4 py-2.5 sm:py-3 hover:bg-gray-100 text-gray-600 transition-colors text-lg">+</button>
                </div>
                <button onclick="addToCartWithQuantity({{ $product->id }})" class="flex-1 btn-primary text-white py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl font-bold flex items-center justify-center space-x-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Добавить в корзину</span>
                </button>
            </div>
            @endif
        </div>
    </div>

    @if($related->count())
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-gray-800 mb-4 sm:mb-6">Похожие товары</h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            @foreach($related as $relatedProduct)
            @include('shop.partials.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
// функции для управления количеством
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    let value = parseInt(input.value);
    if (value < max) {
        input.value = value + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    let value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
    }
}

// Функция добавления в корзину с количеством
function addToCartWithQuantity(productId) {
    const quantityInput = document.getElementById('quantity');
    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
    const button = event.currentTarget;
    const originalText = button.innerHTML;
    
    button.innerHTML = '⏳ Добавление...';
    button.disabled = true;
    
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ 
            product_id: productId,
            quantity: quantity 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('✓ Товар добавлен в корзину!', 'success');
            updateCartCount(data.count);
            
            button.innerHTML = '✓ Добавлено!';
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 1500);
        } else {
            throw new Error(data.message || 'Ошибка добавления');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('✗ Ошибка при добавлении товара', 'error');
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Функция показа уведомления 
function showNotification(message, type) {
    const oldNotifications = document.querySelectorAll('.notification-toast');
    oldNotifications.forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-4 right-4 z-50 px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
        type === 'success' 
            ? 'bg-green-500' 
            : 'bg-red-500'
    } text-white font-semibold text-sm sm:text-base`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 10);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count, .cart-count-mobile');
    cartCountElements.forEach(el => {
        el.textContent = count;
        if (count > 0) {
            el.classList.remove('hidden');
        } else {
            el.classList.add('hidden');
        }
    });
}
</script>
@endsection