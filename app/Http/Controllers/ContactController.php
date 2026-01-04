<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Toon het contactformulier
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Verwerk het contactformulier en verstuur email naar admin
     */
    public function store(Request $request)
    {
        // Valideer de formulierdata
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Sla het bericht op in de database
        $contactMessage = ContactMessage::create($validated);

        // Verstuur email naar admin
        // Admin email uit .env of gebruik eerste admin user
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        
        Mail::to($adminEmail)->send(new ContactFormMail($contactMessage));

        // Redirect terug met success message
        return redirect()->route('contact')->with('success', 'Bedankt voor je bericht! We nemen zo snel mogelijk contact met je op.');
    }
}
