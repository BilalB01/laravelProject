<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminNewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'published_at' => ['required', 'date'],
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news-images', 'public');
            $data['image_path'] = $path;
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Nieuwsitem succesvol aangemaakt.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['required', 'date'],
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            
            $path = $request->file('image')->store('news-images', 'public');
            $data['image_path'] = $path;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Nieuwsitem succesvol bijgewerkt.');
    }

    public function destroy(News $news)
    {
        // Delete image if exists
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Nieuwsitem succesvol verwijderd.');
    }
}
