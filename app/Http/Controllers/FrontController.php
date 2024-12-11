<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Author;
use App\Models\BannerAdvertisment;
use App\Models\Category;
use Illuminate\Http\Request;
use Livewire\Features\SupportModels\Article;

class FrontController extends Controller
{
    // VIEW
    public function index()
    {
        // ambil data dari DB
        $categories = Category::all(); // eloquent all

        $articles = ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured') // Mengambil not_featured
            ->latest()
            ->take(3)
            ->get();

        $featured_articles = ArticleNews::with(['category'])
            ->where('is_featured', 'featured') // Mengambil featured
            ->inRandomOrder()
            ->take(3)
            ->get();

        $authors = Author::all(); // panggil data author dari db

        // Ambil iklan random yang sedang active max  1
        $bannerads = BannerAdvertisment::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            // ->take(1)
            ->first();

        return view('front.index', compact('categories', 'articles', 'authors', 'featured_articles', 'bannerads')); // compact kirim ke halaman depan
    }
}
