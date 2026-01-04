<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::with('profile')->orderBy('created_at', 'desc')->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->boolean('is_admin'),
            'email_verified_at' => now(),
        ]);

        // Create profile for the new user
        $user->profile()->create([
            'username' => $request->name,
            'about_me' => '',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Toggle admin status for a user.
     */
    public function toggleAdmin(User $user)
    {
        // Prevent toggling admin status of the default admin (ID 1)
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'De default admin kan niet worden gedemote.');
        }

        // Prevent users from toggling their own admin status
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Je kunt je eigen admin status niet wijzigen.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $status = $user->is_admin ? 'admin' : 'gebruiker';
        
        return redirect()->route('admin.users.index')
            ->with('success', "Gebruiker succesvol gewijzigd naar {$status}.");
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        // Prevent deletion of the default admin (ID 1)
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'De default admin kan niet worden verwijderd.');
        }

        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Je kunt jezelf niet verwijderen.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol verwijderd.');
    }
}
