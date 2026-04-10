<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (session('user_id')) return redirect()->route('home');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Имя обязательно',
            'email.required' => 'Email обязателен',
            'email.unique' => 'Email уже зарегистрирован',
            'password.required' => 'Пароль обязателен',
            'password.min' => 'Пароль минимум 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        session(['user_id' => $user->id, 'user_name' => $user->name, 'user_email' => $user->email]);
        return redirect()->route('home')->with('success', 'Добро пожаловать, ' . $user->name . '!');
    }

    public function showLogin()
    {
        if (session('user_id')) return redirect()->route('home');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email обязателен',
            'password.required' => 'Пароль обязателен',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Неверный email или пароль']);
        }

        session(['user_id' => $user->id, 'user_name' => $user->name, 'user_email' => $user->email]);
        return redirect()->route('home')->with('success', 'С возвращением, ' . $user->name . '!');
    }

    public function logout()
    {
        session()->forget(['user_id', 'user_name', 'user_email']);
        return redirect()->route('home');
    }
}