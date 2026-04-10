@extends('layouts.app')
@section('title', 'Оплата заказа — RudvetStore')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        </div>
        <h1 class="text-3xl font-black text-gray-800">Оплата заказа #{{ $order->id }}</h1>
        <p class="text-gray-500 mt-2">Сумма к оплате: <span class="font-black text-purple-600 text-xl">{{ number_format($order->total, 0, '.', ' ') }} ₽</span></p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <!-- демо -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
            <p class="text-blue-700 text-sm font-medium">💡 Демонстрационная оплата. Любые данные карты будут приняты.</p>
            <p class="text-blue-600 text-xs mt-1">Пример: 4242 4242 4242 4242 / 12/25 / 123</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('checkout.payment.process', $order->id) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Номер карты</label>
                <input type="text" name="card_number" value="4242 4242 4242 4242" maxlength="19" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 text-lg font-mono tracking-widest" placeholder="0000 0000 0000 0000" required>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Имя владельца</label>
                <input type="text" name="card_name" value="IVAN IVANOV" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 uppercase" placeholder="IVAN IVANOV" required>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Срок действия</label>
                    <input type="text" name="card_expiry" value="12/25" maxlength="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 font-mono" placeholder="MM/YY" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                    <input type="text" name="card_cvv" value="123" maxlength="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 font-mono" placeholder="123" required>
                </div>
            </div>
            <button type="submit" class="w-full btn-primary text-white py-4 rounded-xl font-bold text-lg flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>Оплатить {{ number_format($order->total, 0, '.', ' ') }} ₽</span>
            </button>
        </form>
    </div>
</div>
@endsection
