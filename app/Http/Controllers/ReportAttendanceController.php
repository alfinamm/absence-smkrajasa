<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\StudentAttendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportAttendanceController extends Controller
{
    public function index()
    {
        $classes = ClassModel::query()->paginate(10);

        return view('report-attendance.index', ['classes' => $classes]);
    }

    public function showByToken(Request $request)
    {
        $academicYears = AcademicYear::all();
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $academic_year_id = $request->get('academic_year_id');
        if ($request->academic_year_id != null) {
            # code...
            $students = Student::with(['attendances' => function ($q) use ($request, $date) {
                $q->whereHas('academicYear', function ($query) use ($request) {
                    $query->where('id', $request->academic_year_id);
                });
            }])->where('user_id', Auth::id())->first();
        } else {
            $academic_year = AcademicYear::query()->where('status', '=', 1)->first();
            if ($academic_year) $academic_year_id =  $academic_year->id;
            $students = Student::with(['attendances' => function ($q) use ($academic_year_id, $date) {
                $q->whereHas('academicYear', function ($query) use ($academic_year_id) {
                    $query->where('id', $academic_year_id);
                });
            }])->where('user_id', Auth::id())->first();
        }

        if ($request->academic_year_id != null) {
            $historyAttandance = StudentAttendance::whereHas('academicYear', function ($query) use ($request) {
                $query->where('id', $request->academic_year_id);
            })->where('student_id', $students->id)->get();
        } else {
            $academicYearsActive = AcademicYear::select('id')->where('status', 1)->first();
            $historyAttandance = StudentAttendance::whereHas('academicYear', function ($query) use ($academicYearsActive) {
                $query->where('id', $academicYearsActive->id);
            })->where('student_id', $students->id)->paginate(10);
        }
        $charts = [];
        // dd($students);
        return view('report-attendance.showByToken', compact('students', 'date', 'academic_year_id', 'academicYears', 'historyAttandance'));
    }

    public function showBy(Request $request, ClassModel $class, Student $student)
    {
        if ($request->academic_year_id != null) {
            $historyAttandance = StudentAttendance::whereHas('academicYear', function ($query) use ($request) {
                $query->where('id', $request->academic_year_id);
            })->where('student_id', $student->id)->get();
        } else {
            $academicYearsActive = AcademicYear::select('id')->where('status', 1)->first();
            $historyAttandance = StudentAttendance::whereHas('academicYear', function ($query) use ($academicYearsActive) {
                $query->where('id', $academicYearsActive->id);
            })->where('student_id', $student->id)->paginate(10);
            // dd($historyAttandance);
        }
        return view('report-attendance.showById', compact('student', 'historyAttandance'));
    }

    public function show(ClassModel $class, Request $request)
    {
        $academicYears = AcademicYear::all();
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $academic_year_id = $request->get('academic_year_id', 0);
        if ($request->academic_year_id != null) {
            # code...
            $students = Student::with(['attendances' => function ($q) use ($request, $date) {
                $q->whereHas('academicYear', function ($query) use ($request) {
                    $query->where('id', $request->academic_year_id);
                });
            }])->where("class_id", $class->id)->paginate(10);
        } else {
            # code...
            $academic_year = AcademicYear::query()->where('status', '=', 1)->first();
            if ($academic_year) $academic_year_id =  $academic_year->id;
            $students = Student::where("class_id", $class->id)->paginate(10);
        }
        $charts = [];
        // dd($students);

        return view('report-attendance.show', compact('class', 'students', 'date', 'academic_year_id', 'academicYears'));
    }


    public function charts(ClassModel $class, Request $request)
    {
        $academic_year = AcademicYear::query()->where('status', '=', 1)->first();

        $academic_year_id = $request->get('academic_year_id', $academic_year->id);
        $students = Student::query()->where("class_id", $class->id)->get();
        $charts = [
            "attend" => [],
            "late" => [],
            "permit" => [],
            "sick" => [],
            "alpha" => [],
        ];
        $items = [];
        foreach ($students as $student) {
            $res = StudentAttendance::query()->selectRaw('student_id, status, COUNT(*) as total')->where('student_id', $student->id)->where('academic_year_id', $academic_year_id)->groupBy('status', 'student_id')->get();
            $total = ($totals = array_column(array_filter($res->toArray(), fn ($item) => $item['status'] == 0), 'total')) ? reset($totals) : null;
            array_push($charts['alpha'], $total ? $total : 0);
            $total = ($totals = array_column(array_filter($res->toArray(), fn ($item) => $item['status'] == 1), 'total')) ? reset($totals) : null;
            array_push($charts['attend'], $total ? $total : 0);
            $total = ($totals = array_column(array_filter($res->toArray(), fn ($item) => $item['status'] == 2), 'total')) ? reset($totals) : null;
            array_push($charts['late'], $total ? $total : 0);
            $total = ($totals = array_column(array_filter($res->toArray(), fn ($item) => $item['status'] == 3), 'total')) ? reset($totals) : null;
            array_push($charts['permit'], $total ? $total : 0);
            $total = ($totals = array_column(array_filter($res->toArray(), fn ($item) => $item['status'] == 4), 'total')) ? reset($totals) : null;
            array_push($charts['sick'], $total ? $total : 0);

            array_push($items, $student->name);
        }

        $series = [
            ['name' => "Hadir", 'data' => $charts['attend']],
            ['name' => "Telat", 'data' => $charts['late']],
            ['name' => "Izin", 'data' => $charts['permit']],
            ['name' => "Sakit", 'data' => $charts['sick']],
            ['name' => "Alpha", 'data' => $charts['alpha']],
        ];
        return response()->json(['series' => $series, 'items' => $items]);
    }
    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nisn' => 'required|string',
            'name' => 'required|string',
            'user_id' => 'nullable',
            'class_id' => 'required',
        ]);
        if (intval($request->status) === 1) Student::query()->update(['status' => 0]);

        $student->update($request->all());

        return redirect()->route('student.index')->with('success', 'Murid berhasil diperbarui.');
    }
}
