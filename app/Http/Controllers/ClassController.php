<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        return view('class.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:classes,code',
            'name' => 'required|string',
        ]);
        ClassModel::create($request->all());

        return redirect()->route('class.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(ClassModel $class)
    {
        return view('class.show', compact('class'));
    }

    public function edit(ClassModel $class)
    {
        return view('class.edit', compact('class'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
        ]);
        if (intval($request->status) === 1) ClassModel::query()->update(['status' => 0]);

        $class->update($request->all());

        return redirect()->route('class.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()->route('class.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
