<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'image_url' => 'nullable|url',
            'featured' => 'boolean',
            'active' => 'boolean',
            'specs' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name'] . '-' . time());
        $validated['featured'] = $request->has('featured');
        $validated['active'] = $request->has('active');

        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Товар успешно добавлен!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'image_url' => 'nullable|url',
            'specs' => 'nullable|string',
        ]);

        $validated['featured'] = $request->has('featured');
        $validated['active'] = $request->has('active');

        $product = Product::findOrFail($id);
        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар удалён!');
    }
}