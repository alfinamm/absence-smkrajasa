<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'subject' => 'required|unique:roles,subject',
        ]);
        Role::create($request->all());

        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function show(Role $role)
    {
        return view('role.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'subject' => 'required',
        ]);
        if (intval($request->status) === 1) Role::query()->update(['status' => 0]);

        $role->update($request->all());

        return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus.');
    }
}
