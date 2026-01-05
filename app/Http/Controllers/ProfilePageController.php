<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfilePageController extends Controller
{
    /**
     * Display the specified user's public profile.
     */
    public function show($username)
    {
        $profile = Profile::where('username', $username)->firstOrFail();
        $user = $profile->user;
        
        // Haal berichten op voor dit profiel
        $messages = \App\Models\ProfileMessage::where('receiver_id', $user->id)
            ->with(['sender.profile'])
            ->latest()
            ->get();

        return view('profiles.show', compact('profile', 'user', 'messages'));
    }

    /**
     * Show the form for editing the authenticated user's profile.
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;

        return view('profiles.edit', compact('user', 'profile'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('profiles')->ignore($profile->id)],
            'birthday' => ['nullable', 'date', 'before:today'],
            'profile_photo' => ['nullable', 'image', 'max:1024'], // Max 1MB
            'about_me' => ['nullable', 'string', 'max:1000'],
        ]);

        // Update User name
        $user->update([
            'name' => $request->name,
        ]);

        $data = [
            'username' => $request->username,
            'birthday' => $request->birthday,
            'about_me' => $request->about_me,
        ];

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($profile->profile_photo) {
                // Determine path and delete if needed (simplified for now, assumes default storage)
                 \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $path;
        }

        $profile->update($data);

        return redirect()->route('profile.show', $profile->username)
            ->with('success', 'Profiel succesvol bijgewerkt.');
    }
}
