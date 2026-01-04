<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostDeletedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Toon alle posts (community feed)
     */
    public function index()
    {
        // Haal alle posts op met user en profile relaties, nieuwste eerst
        $posts = Post::with(['user.profile'])->latest()->paginate(20);
        
        return view('posts.index', compact('posts'));
    }

    /**
     * Maak een nieuwe post
     */
    public function store(Request $request)
    {
        // Valideer de post data
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Verwerk afbeelding upload indien aanwezig
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
        }

        // Maak de post
        auth()->user()->posts()->create([
            'content' => $validated['content'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Je post is succesvol geplaatst!');
    }

    /**
     * Verwijder een post
     */
    public function destroy(Request $request, Post $post)
    {
        // Check of gebruiker eigenaar is of admin
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Je hebt geen toestemming om deze post te verwijderen.');
        }

        // Als admin verwijdert, vraag om reden
        $deleteReason = null;
        if (auth()->user()->isAdmin() && auth()->id() !== $post->user_id) {
            $validated = $request->validate([
                'delete_reason' => ['required', 'string', 'max:500'],
            ]);
            $deleteReason = $validated['delete_reason'];
        }

        // Verwijder afbeelding indien aanwezig
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // Bewaar post data voor email
        $postUser = $post->user;
        $postContent = $post->content;

        // Verwijder de post
        $post->delete();

        // Verstuur email naar post eigenaar als admin heeft verwijderd
        if ($deleteReason && $postUser) {
            Mail::to($postUser->email)->send(
                new PostDeletedMail($postUser, $postContent, $deleteReason)
            );
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post succesvol verwijderd.');
    }
}
