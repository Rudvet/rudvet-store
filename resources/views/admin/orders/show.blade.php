@extends('layouts.admin')
@section('title', 'Заказ #{{ $order->id }}')
@section('content')
<div class="p-6 max-w-4xl">
    <a href="{{ route('admin.orders.index') }}" class="text-purple-600 hover:underline text-sm">← Назад к заказам</a>
    <div class="flex items-center justify-between mt-2 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Заказ #{{ $order->id }}</h1>
        <span class="px-3 py-1.5 rounded-xl text-sm font-semibold
            @if($order->status === 'delivered') bg-green-100 text-green-700
            @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
            @elseif($order->status === 'processing') bg-blue-100 text-blue-700
            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
            @else bg-yellow-100 text-yellow-700 @endif">
            {{ $order->status_label }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Данные покупателя</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Имя:</span><span class="font-medium">{{ $order->first_name }} {{ $order->last_name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Email:</span><span class="font-medium">{{ $order->email }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Телефон:</span><span class="font-medium">{{ $order->phone }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Адрес:</span><span class="font-medium">{{ $order->address }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Город:</span><span class="font-medium">{{ $order->city }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Дата:</span><span class="font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Оплата:</span><span class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-red-600' }}">{{ $order->payment_status === 'paid' ? 'Оплачен' : 'Не оплачен' }}</span></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-800 mb-4">Изменить статус</h2>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf @method('PUT')
                <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 mb-4">
                    @foreach(['pending' => 'Ожидает', 'processing' => 'В обработке', 'shipped' => 'Отправлен', 'delivered' => 'Доставлен', 'cancelled' => 'Отменён'] as $val => $label)
                    <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full py-3 gradient-bg text-white rounded-xl font-semibold hover:opacity-90 transition-all">Обновить статус</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Товары в заказе</h2>
        </div>
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500">Товар</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500">Цена</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500">Кол-во</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500">Итого</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->product_name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ number_format($item->price, 0, '.', ' ') }} ₽</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->quantity }} шт.</td>
                    <td class="px-6 py-4 text-right font-bold">{{ number_format($item->subtotal, 0, '.', ' ') }} ₽</td>
                </tr>
                @endforeach
                <tr class="bg-gray-50">
                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-800">Итого к оплате:</td>
                    <td class="px-6 py-4 text-right font-black text-xl text-purple-600">{{ number_format($order->total, 0, '.', ' ') }} ₽</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
