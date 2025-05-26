<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::all();
        return view('user.index', compact('users', 'roles'));
    }

    public function profile()
    {

        $user = auth()->user();
        return view('profile', compact('user'));
    }
    public function profileEdit(Request $request)
    {

        $user = auth()->user();
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password))
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        $user = User::find($user->id);
        $user->password = Hash::make($request->password);
        $user->save();
        return view('profile', compact('user'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        $data  = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => $request->role_id,
        ];
        //dd($data);
        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable',
            'role_id' => 'required',
        ]);

        if (intval($request->status) === 1) User::query()->update(['status' => 0]);

        $user->update($request->all());

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
