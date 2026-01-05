<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')->get();
        return view('news.index', compact('news'));
    }

    /**
     * Toon een enkel nieuwsitem
     */
    public function show(News $news)
    {
        // Laad comments met user en profile relaties
        $news->load(['comments.user.profile']);
        
        return view('news.show', compact('news'));
    }
}
