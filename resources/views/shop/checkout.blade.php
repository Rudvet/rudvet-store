@extends('layouts.app')
@section('title', 'Оформление заказа — RudvetStore')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-black text-gray-800 mb-8">Оформление заказа</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="font-bold text-gray-800 text-xl mb-6">Данные доставки</h2>
                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Имя *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 @error('first_name') border-red-400 @enderror" placeholder="Александр" required>
                            @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Фамилия *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Иванов" required>
                            @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email', session('user_email')) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Телефон *</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="+7 900 000-00-00" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Город *</label>
                            <input type="text" name="city" value="{{ old('city') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Москва" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Адрес доставки *</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="ул. Ленина, д. 1, кв. 1" required>
                        </div>
                    </div>

                    <!-- ЧЕКБОКС С СОГЛАСИЕМ (ССЫЛКИ ВРЕМЕННО НА #) -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="terms_agreement" id="terms_agreement" value="1" class="mt-0.5 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500" {{ old('terms_agreement') ? 'checked' : '' }} required>
                            <span class="text-sm text-gray-600 leading-relaxed">
                                Подтверждая заказ, Вы даёте согласие на обработку персональных данных в соответствии с 
                                <a href="#" class="text-purple-600 hover:underline" target="_blank">Политикой обработки персональных данных</a>, 
                                а также соглашаетесь с 
                                <a href="#" class="text-purple-600 hover:underline" target="_blank">Правилами продажи</a>.
                                <br>
                                <span class="text-xs text-gray-400">В случае сохранения банковской карты или счёта СБП, Вы соглашаетесь с 
                                <a href="#" class="text-purple-500 hover:underline" target="_blank">Условиями привязки</a>.</span>
                            </span>
                        </label>
                        @error('terms_agreement')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="mt-6 w-full btn-primary text-white py-4 rounded-xl font-bold text-lg transition-all hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn" disabled>
                        Перейти к оплате →
                    </button>
                </form>
            </div>
        </div>

        <!-- сумма заказа -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit sticky top-20">
            <h2 class="font-bold text-gray-800 text-lg mb-5">Ваш заказ</h2>
            <div class="space-y-3 mb-6">
                @foreach($cartItems as $item)
                <div class="flex items-center space-x-3">
                    <img src="{{ $item['product']->image_url ?: 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-lg object-cover">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-800 truncate">{{ $item['product']->name }}</div>
                        <div class="text-xs text-gray-400">x{{ $item['quantity'] }}</div>
                    </div>
                    <div class="text-sm font-bold">{{ number_format($item['subtotal'], 0, '.', ' ') }} ₽</div>
                </div>
                @endforeach
            </div>
            <div class="border-t pt-4">
                <div class="flex justify-between font-black text-lg">
                    <span>Итого:</span>
                    <span class="gradient-text">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('terms_agreement');
        const submitBtn = document.getElementById('submitBtn');
        
        if (checkbox && submitBtn) {
            checkbox.addEventListener('change', function() {
                submitBtn.disabled = !this.checked;
            });
        }
    });
</script>

<style>
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .gradient-text {
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endsection