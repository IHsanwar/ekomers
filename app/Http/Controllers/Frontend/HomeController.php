<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Produk terbaru (6-8 produk terbaru yang aktif)
        $newProducts = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // Produk populer - menggunakan produk tertua (sudah ada lama, dianggap terbukti populer)
        $popularProducts = Product::where('is_active', true)
            ->oldest()
            ->take(8)
            ->get();

        // Kategori untuk navigation
        $categories = Category::take(6)->get();

        return view('frontend.landing', compact('newProducts', 'popularProducts', 'categories'));
    }
}
