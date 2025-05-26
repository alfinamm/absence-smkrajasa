<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {

        $users = User::all();
        $employees = Employee::all();
        return view('employee.index', compact('employees', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'user_id' => 'nullable',
        ]);
        Employee::create($request->all());

        return redirect()->route('employee.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $users = User::all();
        return view('employee.edit', compact('employee', 'users'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string',
            'user_id' => 'nullable',
        ]);
        if (intval($request->status) === 1) Employee::query()->update(['status' => 0]);

        $employee->update($request->all());

        return redirect()->route('employee.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employee.index')->with('success', 'Guru berhasil dihapus.');
    }
}
