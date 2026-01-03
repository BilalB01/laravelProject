<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\News;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Verwerk zoekquery en toon resultaten
     * Zoekt naar gebruikers (op username) en nieuws (op titel/content)
     */
    public function index(Request $request)
    {
        // Haal de zoekterm op uit de query string
        $query = $request->input('q');
        
        // Initialiseer lege collecties voor resultaten
        $users = collect();
        $news = collect();
        
        // Alleen zoeken als er een query is ingevoerd
        if ($query) {
            // Zoek gebruikers op username (LIKE query voor gedeeltelijke matches)
            // Eager load de user relatie om N+1 queries te voorkomen
            $users = Profile::where('username', 'LIKE', "%{$query}%")
                ->with('user')
                ->limit(10)
                ->get();
            
            // Zoek nieuws op titel OF content
            // Sorteer op publicatiedatum (nieuwste eerst)
            $news = News::where('title', 'LIKE', "%{$query}%")
                ->orWhere('content', 'LIKE', "%{$query}%")
                ->orderBy('published_at', 'desc')
                ->limit(10)
                ->get();
        }
        
        // Retourneer de search view met query en resultaten
        return view('search.index', compact('query', 'users', 'news'));
    }
}
