<?php

namespace App\Http\Controllers;

use App\Models\ProfileMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileMessageController extends Controller
{
    /**
     * Plaats een bericht op een profiel
     */
    public function store(Request $request, $username)
    {
        // Vind de ontvanger
        $receiver = User::whereHas('profile', function($query) use ($username) {
            $query->where('username', $username);
        })->firstOrFail();

        // Valideer het bericht
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        // Maak het bericht
        ProfileMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
            'message' => $validated['message'],
        ]);

        return redirect()->back()
            ->with('success', 'Je bericht is geplaatst!');
    }

    /**
     * Verwijder een bericht
     */
    public function destroy(ProfileMessage $message)
    {
        // Check of gebruiker eigenaar is (ontvanger) of de afzender
        if (auth()->id() !== $message->receiver_id && auth()->id() !== $message->sender_id && !auth()->user()->isAdmin()) {
            abort(403, 'Je hebt geen toestemming om dit bericht te verwijderen.');
        }

        $message->delete();

        return redirect()->back()
            ->with('success', 'Bericht verwijderd.');
    }
}
