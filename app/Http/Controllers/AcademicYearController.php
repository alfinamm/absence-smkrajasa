<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::all();
        return view('academic-year.index', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:academic_years,name',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'semester' => 'required|in:1,2',
        ]);
        AcademicYear::create($request->all());
        if (intval($request->status) === 1) AcademicYear::query()->update(['status' => 0]);

        return redirect()->route('academic-year.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function show(AcademicYear $academicYear)
    {
        return view('academic-year.show', compact('academicYear'));
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('academic-year.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'name' => ["required"],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'semester' => 'required|integer|min:1',
        ]);
        if (intval($request->status) === 1) AcademicYear::query()->update(['status' => 0]);

        $academicYear->update($request->all());

        return redirect()->route('academic-year.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return redirect()->route('academic-year.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
