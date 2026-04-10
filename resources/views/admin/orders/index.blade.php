@extends('layouts.admin')
@section('title', 'Заказы — RudvetStore Admin')
@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Управление заказами</h1>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Клиент</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Сумма</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Оплата</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Статус</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Дата</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-800">#{{ $order->id }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800 text-sm">{{ $order->first_name }} {{ $order->last_name }}</div>
                        <div class="text-xs text-gray-400">{{ $order->email }}</div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $order->payment_status === 'paid' ? 'Оплачен' : 'Не оплачен' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-lg text-xs font-medium
                            @if($order->status === 'delivered') bg-green-100 text-green-700
                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-purple-50 text-purple-600 rounded-lg text-xs font-medium hover:bg-purple-100 transition-colors">Просмотр</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Заказов нет</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection
