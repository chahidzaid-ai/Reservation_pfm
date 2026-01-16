<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; 

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

 

public function update(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'avatar' => ['nullable', 'image', 'max:2048'], // Max 2MB, must be image
        'password' => ['nullable', 'min:8', 'confirmed'],
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    // Handle Avatar Upload
    if ($request->hasFile('avatar')) {
        // Delete old avatar if it exists (optional cleanup)
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new file in "avatars" folder
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    if ($request->filled('password')) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return back()->with('success', 'Profil mis à jour avec succès.');
}
}

