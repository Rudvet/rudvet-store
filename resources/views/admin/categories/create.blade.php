@extends('layouts.admin')
@section('title', 'Добавить категорию')
@section('content')
<div class="p-6 max-w-lg">
    <a href="{{ route('admin.categories.index') }}" class="text-purple-600 hover:underline text-sm">← Назад</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2 mb-6">Добавить категорию</h1>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Название *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Смартфоны">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Иконка (эмодзи)</label>
                <input type="text" name="icon" value="{{ old('icon', '📦') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="📱">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Описание</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Описание категории">{{ old('description') }}</textarea>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="flex-1 text-center py-3 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">Отмена</a>
                <button type="submit" class="flex-1 py-3 gradient-bg text-white rounded-xl font-semibold hover:opacity-90 transition-all">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
