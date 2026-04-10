@extends('layouts.admin')
@section('title', 'Добавить товар — RudvetStore Admin')
@section('content')
<div class="p-6 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-purple-600 hover:underline text-sm">← Назад к товарам</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Добавить новый товар</h1>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Ошибки валидации:</strong>
                <ul class="mt-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Название товара *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 @error('name') border-red-400 @enderror" placeholder="iPhone 15 Pro Max">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Бренд *</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Apple">
                    @error('brand')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Категория *</label>
                    <select name="category_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Цена (₽) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="99990">
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Старая цена (₽)</label>
                    <input type="number" step="0.01" name="old_price" value="{{ old('old_price') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="119990">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Остаток на складе *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400">
                    @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Короткое описание</label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Краткое описание для карточки товара">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Описание *</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Подробное описание товара...">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Характеристики (каждая с новой строки)</label>
                    <textarea name="specs" rows="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 font-mono text-sm" placeholder="Процессор: Apple M3&#10;ОЗУ: 16 ГБ&#10;Накопитель: 512 ГБ SSD">{{ old('specs') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">URL изображения</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="https://example.com/image.jpg">
                </div>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="rounded w-4 h-4 text-purple-600">
                        <span class="text-sm font-medium text-gray-700">Активен (виден в каталоге)</span>
                    </label>
                </div>
                <div class="flex items-center">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="rounded w-4 h-4 text-purple-600">
                        <span class="text-sm font-medium text-gray-700">★ Отображать в «Хиты продаж»</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">Отмена</a>
                <button type="submit" class="px-8 py-3 gradient-bg text-white rounded-xl font-semibold hover:opacity-90 transition-all hover:shadow-lg">Добавить товар</button>
            </div>
        </form>
    </div>
</div>
@endsection