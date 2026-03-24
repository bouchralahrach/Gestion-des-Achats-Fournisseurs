<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        }
        if ($request->role) {
            $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'prenom'   => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'prenom'      => $request->prenom,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'telephone'   => $request->telephone,
            'departement' => $request->departement,
            'is_active'   => true,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur créé avec succès !');
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,'.$user->id,
            'role'   => 'required|exists:roles,name',
        ]);

        $user->update($request->except(['password', 'password_confirmation', 'role', '_token', '_method']));

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->role);

        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur mis à jour !');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'Vous ne pouvez pas supprimer votre propre compte.');
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }

    public function toggle(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $msg = $user->is_active ? 'Utilisateur activé.' : 'Utilisateur désactivé.';
        return back()->with('success', $msg);
    }
}