<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    /**
     * Maak een nieuwe comment of reply
     */
    public function store(Request $request, $newsId)
    {
        // Valideer de comment
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'exists:news_comments,id'],
        ]);

        // Maak de comment/reply
        auth()->user()->newsComments()->create([
            'news_id' => $newsId,
            'comment' => $validated['comment'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->back()
            ->with('success', $validated['parent_id'] ? 'Je antwoord is geplaatst!' : 'Je reactie is geplaatst!');
    }

    /**
     * Verwijder een comment
     */
    public function destroy(NewsComment $comment)
    {
        // Check of gebruiker eigenaar is of admin
        if (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Je hebt geen toestemming om deze comment te verwijderen.');
        }

        $comment->delete();

        return redirect()->back()
            ->with('success', 'Comment succesvol verwijderd.');
    }
}
