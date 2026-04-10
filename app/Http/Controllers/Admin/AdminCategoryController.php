<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate(['name' => 'required|string|max:255', 'icon' => 'nullable|string|max:100', 'description' => 'nullable|string']);
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? '📦',
            'description' => $request->description,
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'Категория добавлена!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate(['name' => 'required|string|max:255', 'icon' => 'nullable|string|max:100', 'description' => 'nullable|string']);
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? $category->icon,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена!');
    }
}