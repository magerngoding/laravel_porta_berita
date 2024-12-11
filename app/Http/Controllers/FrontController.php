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

        // Entertaiment not featured
        $entertainment_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        // Entertaiment featured
        $entertainment_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        // Automotive not featured
        $automotive_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Automotive');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        // Automotive featured
        $automotive_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Automotive');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();


        return view('front.index', compact('automotive_articles', 'automotive_featured_articles', 'entertainment_featured_articles', 'entertainment_articles', 'categories', 'articles', 'authors', 'featured_articles', 'bannerads')); // compact kirim ke halaman depan
    }

    // Menampilkan data model bindding misal pilih automotive nanti yg keluar berita list automotive -> Category $category
    public function category(Category $category)
    {
        $categories = Category::all();
        $bannerads = BannerAdvertisment::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        return view('front.category', compact('category', 'categories', 'bannerads'));
    }
}
