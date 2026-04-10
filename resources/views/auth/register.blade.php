<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация — RudvetStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; } .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); } .gradient-text { background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2">
                <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center"><span class="text-white font-black text-xl">R</span></div>
                <span class="text-2xl font-black gradient-text">RudvetStore</span>
            </a>
        </div>
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h1 class="text-2xl font-black text-gray-800 mb-2">Создать аккаунт</h1>
            <p class="text-gray-500 text-sm mb-6">Уже есть аккаунт? <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">Войти</a></p>
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
                @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
            </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ваше имя</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="Александр" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="you@example.com" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Пароль</label>
                    <input type="password" name="password" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="минимум 6 символов" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Подтвердите пароль</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400" required>
                </div>
                <button type="submit" class="w-full gradient-bg text-white font-bold py-3.5 rounded-xl hover:opacity-90 transition-all hover:shadow-lg">Зарегистрироваться</button>
                
                <p class="text-xs text-gray-400 text-center mt-4">
                    Нажимая кнопку «Зарегистрироваться», вы даёте согласие на обработку своих персональных данных в соответствии с 
                    <a href="#" class="text-purple-500 hover:underline">Политикой в отношении обработки персональных данных</a>.
                </p>
            </form>
        </div>
    </div>
</body>
</html>