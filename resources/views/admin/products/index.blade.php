@extends('layouts.admin')
@section('title', 'Товары — RudvetStore Admin')
@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Управление товарами</h1>
            <p class="text-gray-500 text-sm mt-1">Всего: {{ $products->total() }} товаров</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl text-white font-semibold gradient-bg hover:opacity-90 transition-all hover:shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Добавить товар</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Товар</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Категория</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Цена</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Склад</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Статус</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $product->image_url ?: 'https://via.placeholder.com/48' }}" alt="" class="w-12 h-12 rounded-xl object-cover">
                            <div>
                                <div class="font-semibold text-gray-800 text-sm">{{ $product->name }}</div>
                                <div class="text-xs text-gray-400">{{ $product->brand }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">{{ number_format($product->price, 0, '.', ' ') }} ₽</div>
                        @if($product->old_price)
                        <div class="text-xs text-gray-400 line-through">{{ number_format($product->old_price, 0, '.', ' ') }} ₽</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">{{ $product->stock }} шт.</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            @if($product->active)
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-lg font-medium">Активен</span>
                            @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-lg font-medium">Скрыт</span>
                            @endif
                            @if($product->featured)
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-lg font-medium">★ Хит</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100 transition-colors mr-2">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Ред.
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить товар?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100 transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Удал.
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Товаров нет. <a href="{{ route('admin.products.create') }}" class="text-purple-600 hover:underline">Добавить первый →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
