<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function home()
    {
        $featured = Product::limit(8)->get();
        $categories = Category::all();
        return view('home', compact('featured', 'categories'));
    }

    public function categories()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(12);
        return view('categories.show', compact('category', 'products'));
    }

    public function products()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    public function product(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
