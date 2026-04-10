@extends('layouts.admin')
@section('title', 'Редактировать товар — RudvetStore Admin')
@section('content')
<div class="p-6 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-purple-600 hover:underline text-sm">← Назад к товарам</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Редактировать: {{ $product->name }}</h1>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <!-- Основная форма для редактирования товара -->
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" id="editProductForm">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Название товара *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Бренд *</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Категория *</label>
                    <select name="category_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Цена (₽) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Старая цена (₽)</label>
                    <input type="number" step="0.01" name="old_price" value="{{ old('old_price', $product->old_price) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Остаток на складе *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Короткое описание</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Описание *</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Характеристики</label>
                    <textarea name="specs" rows="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 font-mono text-sm">{{ old('specs', $product->specs) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">URL изображения</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="active" {{ old('active', $product->active) ? 'checked' : '' }} class="rounded w-4 h-4 text-purple-600">
                        <span class="text-sm font-medium text-gray-700">Активен (виден в каталоге)</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="featured" {{ old('featured', $product->featured) ? 'checked' : '' }} class="rounded w-4 h-4 text-purple-600">
                        <span class="text-sm font-medium text-gray-700">★ Хит продаж</span>
                    </label>
                </div>
            </div>
        </form>

        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Удалить этот товар?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors font-medium">Удалить товар</button>
            </form>
            <div class="flex space-x-4">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">Отмена</a>
                <button type="submit" form="editProductForm" class="px-8 py-3 gradient-bg text-white rounded-xl font-semibold hover:opacity-90 transition-all hover:shadow-lg">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>
@endsection