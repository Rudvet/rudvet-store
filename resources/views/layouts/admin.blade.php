<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RudvetStore Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover, .sidebar-link.active { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 gradient-bg flex flex-col flex-shrink-0">
        <div class="p-6 border-b border-white/20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-lg">R</span>
                </div>
                <div>
                    <div class="text-white font-bold text-lg">RudvetStore</div>
                    <div class="text-white/60 text-xs">Admin Panel</div>
                </div>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                <span class="font-medium">Дашборд</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span class="font-medium">Товары</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span class="font-medium">Категории</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="font-medium">Заказы</span>
            </a>
        </nav>
        <div class="p-4 border-t border-white/20">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-bold">{{ strtoupper(substr(session('admin_user', 'A'), 0, 1)) }}</span>
                </div>
                <div>
                    <div class="text-white text-sm font-medium">{{ session('admin_user') }}</div>
                    <div class="text-white/50 text-xs">Администратор</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 px-4 bg-white/10 hover:bg-white/20 text-white text-sm rounded-lg transition-colors">Выйти</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
        @if(session('success'))
        <div class="m-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
