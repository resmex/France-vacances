<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UpdateProfileRequest;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index')->with('users', User::orderBy('name')->get());
    }

    public function edit()
    {
        return view('users.edit')->with('user', auth()->user());
    }

    public function update(UpdateProfileRequest $request)
    {
        auth()->user()->update([
            'name'  => $request->name,
            'about' => $request->about,
        ]);

        session()->flash('success', 'Profile updated successfully.');

        return redirect()->back();
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:customer,admin,owner,finance,it'],
        ]);

        $user->update(['role' => $request->role]);

        session()->flash('success', "Role updated to «{$user->roleLabel()}» for {$user->name}.");

        return redirect()->route('users.index');
    }

    public function makeAdmin(User $user)
    {
        $user->update(['role' => 'admin']);

        session()->flash('success', "{$user->name} is now an Administrator.");

        return redirect()->route('users.index');
    }
}
