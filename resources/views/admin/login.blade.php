<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в Admin Panel — RudvetStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; } .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }</style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="text-white text-3xl font-black">R</span>
            </div>
            <h1 class="text-3xl font-black text-white">RudvetStore Admin</h1>
            <p class="text-white/70 mt-1">Панель управления магазином</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Credentials hint -->
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 mb-6">
                <p class="text-xs font-semibold text-purple-700 mb-2">🔑 Тестовые доступы:</p>
                <p class="text-xs text-purple-600">admin@rudvetstore.com / admin123</p>
                <p class="text-xs text-purple-600">manager@rudvetstore.com / manager123</p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="/admin/login" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@rudvetstore.com" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Пароль</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all" required>
                </div>
                <button type="submit" class="w-full gradient-bg text-white font-bold py-3 rounded-xl hover:opacity-90 transition-all hover:shadow-lg">Войти в панель</button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-purple-600 transition-colors">← Вернуться в магазин</a>
            </div>
        </div>
    </div>
</body>
</html>
