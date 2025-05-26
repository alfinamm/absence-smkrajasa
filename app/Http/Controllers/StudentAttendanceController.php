<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $academicYear = AcademicYear::where('status', 1)->first("id");
        $date = Carbon::parse($request->date)->format('Y-m-d');
        // dd($date);
        if ($request->date != null && $request->academic_year_id != null) {
            # code...
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $students = Student::with(['attendances' => function ($q) use ($request, $date) {
                $q->whereHas('academicYear', function ($query) use ($request) {
                    $query->where('id', $request->academic_year_id);
                })->where(DB::raw("CAST(clock_in as date)"), $date)->where(DB::raw("CAST(clock_out as date)"), $date);
            }])->where("class_id", $class->id)->paginate(10);
        } else {
            # code...
            $students = Student::where("class_id", $class->id)->paginate(10);
        }

        return view('student-attendance.show', compact('class', 'students', 'date', 'academicYears', 'academicYear'));
    }

    public function edit(Request $request, ClassModel $class,  Student $student)
    {
        $studentAttendance = StudentAttendance::find($request->get("student-attendance"));
        return view('student-attendance.edit', compact('student', 'class', 'studentAttendance'));
    }

    public function update(Request $request, ClassModel $class, Student $student)
    {
        $request->validate([
            'status' => 'nullable',
        ]);
        // if (intval($request->status) === 1) StudentAttendance::query()->update(['status' => 0]);
        $studentAttendance = StudentAttendance::find($request->id);

        $studentAttendance->status = $request->status;
        $studentAttendance->save();

        return redirect()->route('student-attendance.show', ['class' => $class->id, 'student' => $student->id])->with('success', 'Kehadiran berhasil diperbarui.');
    }
}
