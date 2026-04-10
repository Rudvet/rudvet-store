<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('active', true)->where('featured', true)->with('category')->take(8)->get();
        $newProducts = Product::where('active', true)->with('category')->orderBy('created_at', 'desc')->take(8)->get();
        $categories = Category::withCount('products')->get();
        $stats = [
            'products' => Product::where('active', true)->count(),
            'categories' => Category::count(),
            'brands' => Product::where('active', true)->distinct('brand')->count('brand'),
        ];
        return view('shop.home', compact('featuredProducts', 'newProducts', 'categories', 'stats'));
    }

    public function catalog(Request $request)
    {
        $query = Product::where('active', true)->with('category');

        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        if ($request->brand) {
            $query->where('brand', $request->brand);
        }
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'new') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $brands = Product::where('active', true)->distinct()->pluck('brand')->filter()->sort()->values();
        $selectedCategory = $request->category;

        return view('shop.catalog', compact('products', 'categories', 'brands', 'selectedCategory'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->take(4)
            ->get();
        return view('shop.product', compact('product', 'related'));
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $products = Product::where('active', true)
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            })
            ->with('category')
            ->paginate(12);
        return view('shop.search', compact('products', 'q'));
    }
}