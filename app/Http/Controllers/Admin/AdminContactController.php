<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    /**
     * Toon alle contactberichten voor admin
     */
    public function index()
    {
        // Haal alle contactberichten op, nieuwste eerst
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.contact.index', compact('messages'));
    }

    /**
     * Toon een specifiek contactbericht
     */
    public function show(ContactMessage $contactMessage)
    {
        return view('admin.contact.show', compact('contactMessage'));
    }

    /**
     * Verwijder een contactbericht
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        
        return redirect()->route('admin.contact.index')
            ->with('success', 'Contactbericht succesvol verwijderd.');
    }

    /**
     * Verstuur een antwoord op een contactbericht
     */
    public function reply(Request $request, ContactMessage $contactMessage)
    {
        // Valideer het antwoord
        $validated = $request->validate([
            'reply_message' => ['required', 'string', 'max:5000'],
        ]);

        // Verstuur email naar de verzender
        \Mail::to($contactMessage->email)->send(
            new \App\Mail\ContactReplyMail($contactMessage, $validated['reply_message'])
        );

        return redirect()->route('admin.contact.show', $contactMessage)
            ->with('success', 'Je antwoord is succesvol verzonden naar ' . $contactMessage->email);
    }
}
