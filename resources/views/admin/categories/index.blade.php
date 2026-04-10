@extends('layouts.admin')
@section('title', 'Категории — RudvetStore Admin')
@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Категории товаров</h1>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl text-white font-semibold gradient-bg hover:opacity-90 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Добавить</span>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $cat)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-4xl">{{ $cat->icon }}</span>
                <span class="text-sm bg-purple-100 text-purple-700 px-2 py-1 rounded-lg font-medium">{{ $cat->products_count }} товаров</span>
            </div>
            <h3 class="font-bold text-gray-800 text-lg">{{ $cat->name }}</h3>
            <p class="text-gray-500 text-sm mt-1">{{ $cat->description }}</p>
            <div class="flex space-x-2 mt-4">
                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="flex-1 text-center py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors">Редактировать</a>
                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Удалить категорию?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="py-2 px-3 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors">✕</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
