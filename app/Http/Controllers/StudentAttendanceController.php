<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        $classes = ClassModel::query()->paginate(10);
        return view('student-attendance.index', ['classes' => $classes]);
    }

    public function show(ClassModel $class, Request $request)
{
    $academicYears = AcademicYear::all();
    $academicYear = AcademicYear::where('status', 1)->first();

    $date = $request->date ? Carbon::parse($request->date)->format('Y-m-d') : now()->format('Y-m-d');
    $academicYearId = $request->academic_year_id ?? $academicYear?->id;

    $students = Student::with(['attendances' => function ($q) use ($academicYearId, $date) {
            $q->where('academic_year_id', $academicYearId)
              ->whereDate('date', $date);
        }])
        ->where('class_id', $class->id)
        ->get(); // gunakan get() karena kita tidak perlu paginate untuk looping dan relasi

    return view('student-attendance.show', compact('class', 'students', 'date', 'academicYears', 'academicYear'));
}


    public function edit(Request $request, ClassModel $class, Student $student)
    {
        $studentAttendance = StudentAttendance::find($request->get("student-attendance"));

        return view('student-attendance.edit', compact('student', 'class', 'studentAttendance'));
    }

    public function update(Request $request, ClassModel $class, Student $student)
    {
        $request->validate([
            'status' => 'nullable',
        ]);

        $studentAttendance = StudentAttendance::find($request->id);

        if ($studentAttendance) {
            $studentAttendance->status = $request->status;
            $studentAttendance->save();
        }

        return redirect()->route('student-attendance.show', [
            'class' => $class->id,
            'student' => $student->id,
            'date' => $studentAttendance->date ?? now()->toDateString(),
            'academic_year_id' => $studentAttendance->academic_year_id ?? null,
        ])->with('success', 'Kehadiran berhasil diperbarui.');
    }
}
