<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query()->orderBy('name');

        if ($request->filled('role')) {
            $q->where('role', $request->string('role'));
        }
        if ($request->filled('active')) {
            $q->where('is_active', (bool)$request->boolean('active'));
        }
        if ($request->filled('search')) {
            $s = '%'.$request->string('search').'%';
            $q->where('name', 'like', $s)->orWhere('email', 'like', $s);
        }

        $users = $q->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user, AuditLogger $logger)
    {
        $data = $request->validate([
            'role' => ['required', 'in:guest,user,manager,admin'],
            'is_active' => ['required', 'boolean'],
        ]);

        $user->update($data);
        $logger->log($request->user()->id, 'user.update', User::class, $user->id, $data);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour.');
    }
}
