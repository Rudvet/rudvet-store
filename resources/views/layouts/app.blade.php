<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RudvetStore — Магазин техники')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-text { background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.2); }
        .glass { backdrop-filter: blur(20px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); }
        .nav-glass { backdrop-filter: blur(20px); background: rgba(255,255,255,0.95); border-bottom: 1px solid rgba(0,0,0,0.08); }
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(102,126,234,0.4); }
        .pulse-dot { animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .slide-in { animation: slideIn 0.6s ease forwards; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .product-img { transition: transform 0.5s ease; }
        .product-img:hover { transform: scale(1.05); }
        .shimmer { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        ::-webkit-scrollbar { width: 6px; } ::-webkit-scrollbar-track { background: #f1f1f1; } ::-webkit-scrollbar-thumb { background: #667eea; border-radius: 3px; }
        
        /* Стили для мобильного меню */
        .mobile-menu-enter {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, opacity 0.2s ease-out;
        }
        .mobile-menu-enter-active {
            max-height: 500px;
            opacity: 1;
        }
        .mobile-menu-exit {
            max-height: 500px;
            opacity: 1;
        }
        .mobile-menu-exit-active {
            max-height: 0;
            opacity: 0;
            transition: max-height 0.3s ease-out, opacity 0.2s ease-out;
        }
        .burger-line {
            transition: all 0.3s ease;
        }
        .burger-open .line1 {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .burger-open .line2 {
            opacity: 0;
        }
        .burger-open .line3 {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        html {
            scroll-behavior: smooth;
        }
    </style>
    @yield('head')
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<nav class="nav-glass sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-9 h-9 gradient-bg rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-lg">R</span>
                </div>
                <span class="text-xl font-bold gradient-text">RudvetStore</span>
            </a>

            <!-- Search (Desktop) -->
            <form action="{{ route('search') }}" method="GET" class="hidden md:flex flex-1 max-w-lg mx-8">
                <div class="relative w-full">
                    <input type="text" name="q" placeholder="Поиск товаров, брендов..." class="w-full pl-4 pr-12 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent bg-gray-50 text-sm" value="{{ request('q') }}">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-purple-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            <!-- Desktop Navigation Links (Вход, Регистрация, Корзина) -->
            <div class="hidden md:flex items-center space-x-3">
                <!-- User -->
                @if(session('user_id'))
                <div class="relative group">
                    <button class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-bold">{{ strtoupper(substr(session('user_name'), 0, 1)) }}</span>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ session('user_name') }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute right-0 top-full mt-1 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('orders.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-t-xl">Мои заказы</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">Выйти</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 transition-colors">Войти</a>
                <a href="{{ route('register') }}" class="btn-primary px-4 py-2 text-sm font-semibold text-white rounded-xl">Регистрация</a>
                @endif
                
                <!-- Cart (справа от кнопки регистрация) -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-purple-600 transition-colors ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                    @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 bg-purple-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold cart-count">{{ $cartCount }}</span>
                    @else
                    <span class="absolute -top-1 -right-1 bg-purple-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold cart-count hidden">0</span>
                    @endif
                </a>
            </div>

            <!-- Mobile: Cart Icon + Burger Menu Button -->
            <div class="flex items-center space-x-3 md:hidden">
                <!-- Cart Icon for Mobile -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-purple-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                    @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 bg-purple-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold cart-count-mobile">{{ $cartCount }}</span>
                    @else
                    <span class="absolute -top-1 -right-1 bg-purple-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold cart-count-mobile hidden">0</span>
                    @endif
                </a>

                <!-- Burger Menu Button -->
                <button id="burgerBtn" class="flex flex-col items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-6 h-5 flex flex-col justify-between">
                        <span class="burger-line line1 w-6 h-0.5 bg-gray-600 rounded-full transition-all duration-300"></span>
                        <span class="burger-line line2 w-6 h-0.5 bg-gray-600 rounded-full transition-all duration-300"></span>
                        <span class="burger-line line3 w-6 h-0.5 bg-gray-600 rounded-full transition-all duration-300"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu-enter md:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="px-4 py-4 space-y-4">
            <!-- Search for Mobile -->
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Поиск товаров..." class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-400 bg-gray-50 text-sm" value="{{ request('q') }}">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
            

            <!-- User Section for Mobile -->
            @if(session('user_id'))
            <div class="border-t border-gray-100 pt-4 mt-2">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center">
                        <span class="text-white font-bold">{{ strtoupper(substr(session('user_name'), 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ session('user_name') }}</p>
                        <p class="text-xs text-gray-500">{{ session('user_email') }}</p>
                    </div>
                </div>
                <a href="{{ route('orders.index') }}" class="block py-2 text-gray-700 hover:text-purple-600 transition-colors">Мои заказы</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 text-red-600 hover:text-red-700 font-medium">Выйти</button>
                </form>
            </div>
            @else
            <div class="border-t border-gray-100 pt-4 mt-2 space-y-3">
                <a href="{{ route('login') }}" class="block text-center py-3 text-gray-700 font-medium border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">Войти</a>
                <a href="{{ route('register') }}" class="block text-center py-3 btn-primary text-white font-semibold rounded-xl">Регистрация</a>
            </div>
            @endif
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
<div class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg slide-in flex items-center space-x-2" id="flash-msg">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    <span>{{ session('success') }}</span>
</div>
<script>setTimeout(() => { const el = document.getElementById('flash-msg'); if(el) el.style.display='none'; }, 3000);</script>
@endif
@if(session('error'))
<div class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg slide-in" id="flash-err">
    {{ session('error') }}
</div>
<script>setTimeout(() => { const el = document.getElementById('flash-err'); if(el) el.style.display='none'; }, 3000);</script>
@endif

<!-- Content -->
@yield('content')

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 py-12 md:py-16">
        <!-- Основная сетка -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-10">
            <!-- Колонка 1: Логотип и описание (скрыто на мобильных) -->
            <div class="hidden md:block text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start space-x-2 mb-4">
                    <div class="w-9 h-9 gradient-bg rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">R</span>
                    </div>
                    <span class="text-xl font-bold text-white">RudvetStore</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed max-w-xs mx-auto md:mx-0">
                    Лучший магазин техники с широким выбором смартфонов, ноутбуков, планшетов и аксессуаров.
                </p>
            </div>

            <!-- Колонка 2: Каталог (скрыто на мобильных) -->
            <div class="hidden md:block">
                <h4 class="text-white font-semibold text-lg mb-4">Каталог</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('catalog') }}?category=smartphones" class="hover:text-purple-400 transition-colors inline-block py-1">📱 Смартфоны</a></li>
                    <li><a href="{{ route('catalog') }}?category=laptops" class="hover:text-purple-400 transition-colors inline-block py-1">💻 Ноутбуки</a></li>
                    <li><a href="{{ route('catalog') }}?category=tablets" class="hover:text-purple-400 transition-colors inline-block py-1">📋 Планшеты</a></li>
                    <li><a href="{{ route('catalog') }}?category=headphones" class="hover:text-purple-400 transition-colors inline-block py-1">🎧 Наушники</a></li>
                    <li><a href="{{ route('catalog') }}?category=speakers" class="hover:text-purple-400 transition-colors inline-block py-1">🔊 Колонки</a></li>
                    <li><a href="{{ route('catalog') }}?category=accessories" class="hover:text-purple-400 transition-colors inline-block py-1">🎒 Аксессуары</a></li>
                </ul>
            </div>
            <div class="hidden md:block">
                <h4 class="text-white font-semibold text-lg mb-4">Покупателям</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('cart.index') }}" class="hover:text-purple-400 transition-colors inline-block py-1">🛒 Корзина</a></li>
                    <li><a href="{{ route('orders.index') }}" class="hover:text-purple-400 transition-colors inline-block py-1">📦 Мои заказы</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-purple-400 transition-colors inline-block py-1">📝 Регистрация</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-purple-400 transition-colors inline-block py-1">🔑 Войти</a></li>
                    <li><a href="#" class="hover:text-purple-400 transition-colors inline-block py-1">📜 Доставка и оплата</a></li>
                    <li><a href="#" class="hover:text-purple-400 transition-colors inline-block py-1">🔄 Возврат товара</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold text-lg mb-4 text-center md:text-left">Контакты</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center space-x-3 justify-center md:justify-start">
                        <span class="text-xl">📞</span>
                        <span>+7 (800) 555-35-35</span>
                    </li>
                    <li class="flex items-center space-x-3 justify-center md:justify-start">
                        <span class="text-xl">✉️</span>
                        <a href="mailto:support@rudvetstore.ru" class="hover:text-purple-400 transition-colors">support@rudvetstore.ru</a>
                    </li>
                    <li class="flex items-center space-x-3 justify-center md:justify-start">
                        <span class="text-xl">📍</span>
                        <span>Омск, Россия</span>
                    </li>
                    <li class="flex items-center space-x-3 justify-center md:justify-start">
                        <span class="text-xl">🕐</span>
                        <span>Пн-Вс: 9:00 — 21:00</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 md:mt-10 pt-6 md:pt-8">
            <p class="text-sm text-gray-500 text-center">
                © {{ date('Y') }} RudvetStore. Все права защищены.
            </p>
        </div>
    </div>
</footer>

<script>

const burgerBtn = document.getElementById('burgerBtn');
const mobileMenu = document.getElementById('mobileMenu');

if (burgerBtn && mobileMenu) {
    burgerBtn.addEventListener('click', () => {
        burgerBtn.classList.toggle('burger-open');
        
        if (mobileMenu.classList.contains('mobile-menu-enter')) {
            mobileMenu.classList.remove('mobile-menu-enter');
            mobileMenu.classList.add('mobile-menu-enter-active');
        } else if (mobileMenu.classList.contains('mobile-menu-enter-active')) {
            mobileMenu.classList.remove('mobile-menu-enter-active');
            mobileMenu.classList.add('mobile-menu-enter');
        } else {
            mobileMenu.classList.add('mobile-menu-enter-active');
        }
    });

    // Close mobile menu when clicking a link
    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('mobile-menu-enter-active');
            mobileMenu.classList.add('mobile-menu-enter');
            burgerBtn.classList.remove('burger-open');
        });
    });
}
</script>

@yield('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.addToCart = function(productId) {
        const button = event.currentTarget;
        const originalText = button.innerHTML;
        
        button.innerHTML = '⏳ Добавление...';
        button.disabled = true;
        
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                product_id: productId,
                quantity: 1 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✓ Товар добавлен в корзину!', 'success');
                
                updateCartCount(data.count);
                
                button.innerHTML = '✓ Добавлено!';
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 1500);
            } else {
                throw new Error(data.message || 'Ошибка добавления');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('✗ Ошибка при добавлении товара', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    };
    
    function showNotification(message, type) {
        const oldNotifications = document.querySelectorAll('.notification-toast');
        oldNotifications.forEach(notif => notif.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
            type === 'success' 
                ? 'bg-green-500' 
                : 'bg-red-500'
        } text-white font-semibold`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 10);
        
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count, .cart-count-mobile');
        cartCountElements.forEach(el => {
            el.textContent = count;
            if (count > 0) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    }
    
    fetch('/cart/count', {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.count !== undefined) {
            updateCartCount(data.count);
        }
    })
    .catch(error => console.error('Error loading cart count:', error));
});
</script>
</body>
</html>