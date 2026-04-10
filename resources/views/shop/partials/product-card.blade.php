<div class="card-hover bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
    <div class="relative overflow-hidden bg-gray-50 h-52">
        <img src="{{ $product->image_url ?: 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=400' }}" alt="{{ $product->name }}" class="product-img w-full h-full object-cover">
        @if($product->discount_percent > 0)
        <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-lg">-{{ $product->discount_percent }}%</div>
        @endif
        @if($product->featured)
        <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-lg">★ Хит</div>
        @endif
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
        <!-- Quick add to cart overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
            <button onclick="addToCart({{ $product->id }})" class="w-full py-2 bg-white text-purple-700 font-bold rounded-xl hover:bg-purple-600 hover:text-white transition-colors text-sm">
                🛒 В корзину
            </button>
        </div>
    </div>
    <div class="p-4">
        <div class="text-xs text-gray-400 mb-1">{{ $product->brand }}</div>
        <a href="{{ route('product.show', $product->id) }}" class="font-bold text-gray-800 hover:text-purple-600 transition-colors line-clamp-2 text-sm leading-snug block">{{ $product->name }}</a>
        @if($product->short_description)
        <p class="text-gray-500 text-xs mt-1 line-clamp-1">{{ $product->short_description }}</p>
        @endif
        <div class="flex items-center justify-between mt-3">
            <div>
                <span class="text-xl font-black text-gray-900">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                @if($product->old_price)
                <span class="text-sm text-gray-400 line-through ml-2">{{ number_format($product->old_price, 0, '.', ' ') }} ₽</span>
                @endif
            </div>
            <span class="text-xs {{ $product->stock > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $product->stock > 0 ? 'В наличии' : 'Нет' }}</span>
        </div>
    </div>
</div>