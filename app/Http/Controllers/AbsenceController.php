<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;

class AbsenceController extends Controller
{
  public function index(Request $request)
{
    $academicYears = AcademicYear::all();
    $academic_year = AcademicYear::where('status', 1)->first();
    $academic_year_id = $academic_year ? $academic_year->id : 0;
    $date = $request->input('date') ?? now()->format('Y-m-d');

    // Jika user memilih tahun ajaran dan tanggal
    if ($request->filled(['academic_year_id', 'date'])) {
        $academic_year_id = $request->academic_year_id;
        $date = Carbon::parse($request->date)->format("Y-m-d");
        $currTS = Carbon::parse($request->date)->format("Y-m-d H:i:s");

        // Upsert data absen untuk semua siswa
        Student::whereNotNull('class_id')
            ->where('class_id', '!=', 0)
            ->chunk(100, function ($students) use ($date, $academic_year_id, $currTS) {
                foreach ($students as $student) {
                    StudentAttendance::upsert([
                        'date' => $date,
                        'student_id' => $student->id,
                        'class_id' => $student->class_id,
                        'status' => 0,
                        'clock_in' => $currTS,
                        'clock_out' => $currTS,
                        'academic_year_id' => $academic_year_id,
                    ], ['date', 'student_id'], ['academic_year_id']);
                }
            });

        // Pastikan academicYears juga dikirim ke absence.open jika dibutuhkan untuk tampilan
        return view('absence.open', compact('academic_year_id', 'date', 'academicYears'));
    }

    // Jika belum ada input, tampilkan form pilih tahun & tanggal
    return view('absence.index', compact('academicYears', 'academic_year_id', 'date'));
}



    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'class_id' => 'required|string',
            'status' => 'required',
            'academic_year_id' => 'required',
            'date' => 'required',
        ]);

        $currTS = Carbon::parse($request->date)->format("Y-m-d H:i:s");
        $currDate = Carbon::parse($request->date)->format("Y-m-d");

        StudentAttendance::create([
            'date' => $request->get('date', $currDate),
            'clock_in' => $currTS,
            'clock_out' => $currTS,
            'student_id' => $request->student_id,
            'class_id' => $request->class_id,
            'status' => $request->status,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('student-attendance.show', ['class' => $request->class_id])->with('success', 'Kehadiran berhasil ditambahkan.');
    }

    public function checkAbsence(Request $request)
    {
        try {

            $student = Student::query()->where("nisn", $request->nisn)->first();
            $academic_year_id = $request->get('academic_year_id', 0);
            if ($student) {
                $currTS = date("Y-m-d H:i:s");
                $currDate = date("Y-m-d");
                $image  = public_path('storage/images/' . $student->image);

                $date = $request->get('date', $currDate);
                $absence = StudentAttendance::where('date', '=', $date)->where('academic_year_id', '=', $academic_year_id)->where('student_id', '=', $student->id)->first();
                if ($absence) {
                    if ($absence->status === 0) {
                        $absence->update([
                            'clock_in' => $currTS,
                            'clock_out' => $currTS,
                            'status' => 1,
                        ]);
                    } else {
                        $absence->update([
                            'clock_out' => $currTS,
                        ]);
                    }
                } else {
                    StudentAttendance::query()->upsert([
                        'date' => $date,
                        'clock_in' => $currTS,
                        'clock_out' => $currTS,
                        'student_id' => $student->id,
                        'class_id' => $student->class_id,
                        'status' => 1,
                        'academic_year_id' => $academic_year_id ? $academic_year_id : AcademicYear::where('status', 1)->first()->id ?? 1,
                    ], ['date', 'student_id'], ['status', 'clock_out']);
                }

                $lastAbsen = StudentAttendance::where('date', '=', $date)->where('academic_year_id', '=', $academic_year_id)->where('student_id', '=', $student->id)->first();

                return response()->json([
                    "id" => $student->id,
                    "image" => '/storage/images/' . $student->image,
                    "name" => $student->name,
                    "nisn" => $student->nisn,
                    "clock_in" =>  date("d M Y H:i:s", strtotime($lastAbsen->clock_in)),
                    "clock_out" => date("d M Y H:i:s", strtotime($lastAbsen->clock_out)),
                ], 200);
            }
            return response('', 404)->json([
                "nisn" => $request->nisn,
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return response('', 404)->json([
                "nisn" => $request->nisn,
            ]);
        }
    }
}
