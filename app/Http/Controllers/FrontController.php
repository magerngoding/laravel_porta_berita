<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    // VIEW
    public function index()
    {
        // ambil data dari DB
        $categories = Category::all(); // eloquent all
        return view('front.index', compact('categories')); // compact kirim ke halaman depan
    }
}
