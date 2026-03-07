<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::active()->featured()->with('category')->take(8)->get();
        $categories = Category::active()->withCount('products')->get();
        $latestProducts = Product::active()->with('category')->latest()->take(8)->get();
        $banners = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts', 'banners'));
    }
}
