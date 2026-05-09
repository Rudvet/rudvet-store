@extends('layouts.app')
@section('title', 'Поиск: {{ $q }} — RudvetStore')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-black text-gray-800 mb-2">Результаты поиска</h1>
    <p class="text-gray-500 mb-8">По запросу «<span class="text-purple-600 font-semibold">{{ $q }}</span>» найдено {{ $products->total() }} товаров</p>
    @if($products->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        @include('shop.partials.product-card')
        @endforeach
    </div>
    <div class="mt-8">{{ $products->links() }}</div>
    @else
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🔍</div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">По запросу «{{ $q }}» ничего не найдено</h3>
        <p class="text-gray-500 mb-6">Попробуйте другой запрос или посмотрите весь каталог</p>
        <a href="{{ route('catalog') }}" class="px-6 py-3 gradient-bg text-white rounded-xl font-semibold">Весь каталог</a>
    </div>
    @endif
</div>
@endsection
@section('scripts')
<script>
function toggleChat() {
    document.getElementById('chat-box').classList.toggle('hidden');
}

function addMessage(text, isUser = false) {
    const container = document.getElementById('chat-messages');
    const div = document.createElement('div');

    div.className = isUser 
        ? 'text-right' 
        : 'text-left';

    div.innerHTML = `
        <span class="inline-block px-3 py-2 rounded-lg ${
            isUser ? 'bg-purple-600 text-white' : 'bg-gray-200'
        }">${text}</span>
    `;

    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
}

function sendMessage() {
    const input = document.getElementById('chat-input');
    const text = input.value;

    if (!text) return;

    addMessage(text, true);
    input.value = '';

    fetch('/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: text })
    })
    .then(res => res.json())
    .then(data => {
        addMessage(data.reply);
    })
    .catch(() => {
        addMessage('Ошибка соединения');
    });
}
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('chat-input');

    if (input) {
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // чтобы не было переноса строки
                sendMessage();
            }
        });
    }
});
</script>