@extends('layouts.admin')

@section('title', 'Дашборд — RudvetStore Admin')

@section('content')
<div class="p-6">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Активные</span>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ $totalProducts }}</div>
            <div class="text-gray-500 text-sm mt-1">Товаров в каталоге</div>
        </div>
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">{{ $pendingOrders }} ожидают</span>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ $totalOrders }}</div>
            <div class="text-gray-500 text-sm mt-1">Всего заказов</div>
        </div>
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">Зарег.</span>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ $totalUsers }}</div>
            <div class="text-gray-500 text-sm mt-1">Пользователей</div>
        </div>
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Оплачено</span>
            </div>
            <div class="text-3xl font-black text-gray-800">{{ number_format($totalRevenue, 0, '.', ' ') }} ₽</div>
            <div class="text-gray-500 text-sm mt-1">Общая выручка</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-800 text-lg">Последние заказы</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-purple-600 text-sm hover:underline">Все заказы →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentOrders as $order)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center text-white font-bold text-sm">{{ $loop->index + 1 }}</div>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">#{{ $order->id }} — {{ $order->first_name }} {{ $order->last_name }}</div>
                            <div class="text-xs text-gray-400">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-gray-800">{{ number_format($order->total, 0, '.', ' ') }} ₽</div>
                        <span class="inline-block text-xs px-2 py-0.5 rounded-full
                            @if($order->status === 'delivered') bg-green-100 text-green-700
                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">{{ $order->status_label }}</span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-gray-400">Заказов пока нет</div>
                @endforelse
            </div>
        </div>

        <!-- Order Status + Top Products -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-800 text-lg mb-4">Статусы заказов</h2>
                @foreach($ordersByStatus as $status => $count)
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-600 capitalize">{{ match($status) { 'pending'=>'Ожидает','processing'=>'В обработке','shipped'=>'Отправлен','delivered'=>'Доставлен','cancelled'=>'Отменён', default=>$status} }}</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-24 bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full gradient-bg" style="width: {{ $totalOrders > 0 ? round($count/$totalOrders*100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-800 w-4">{{ $count }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-800 text-lg mb-4">Топ товары</h2>
                @foreach($topProducts as $product)
                <div class="flex items-center space-x-3 mb-3">
                    <img src="{{ $product->image_url ?: 'https://via.placeholder.com/40' }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-800 truncate">{{ $product->name }}</div>
                        <div class="text-xs text-gray-400">{{ $product->order_items_count }} продаж</div>
                    </div>
                </div>
                @endforeach
                @if($topProducts->isEmpty())<div class="text-gray-400 text-sm">Продаж пока нет</div>@endif
            </div>
        </div>
    </div>
</div>
@endsection
