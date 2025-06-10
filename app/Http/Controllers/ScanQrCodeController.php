<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // untuk debug log (opsional)

class ScanQrCodeController extends Controller
{
    public function index() {
        return view('student-attendance.qr-scan.manual');
    }

    public function store(Request $request) {
        $request->validate([
            'nisn' => 'required|string'
        ]);

        $student = Student::where('nisn', $request->nisn)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }

        $academicYear = AcademicYear::where('status', 1)->first();
        if (!$academicYear) {
            return redirect()->back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $today = Carbon::today()->toDateString();

        StudentAttendance::updateOrCreate(
            [
                'student_id' => $student->id,
                'academic_year_id' => $academicYear->id,
                'date' => $today,
            ],
            [
                'class_id' => $student->class_id,
                'status' => 1,
                'clock_in' => now(),
            ]
        );

        // Kirim WA ke orang tua
        $this->sendWhatsappNotification($student);

        return redirect()->back()->with('success', 'Absensi berhasil untuk ' . $student->name);
    }

    protected function sendWhatsappNotification($student) {
    $token = "woUkq1q2WNHhnhe5HLpr";
    $to = ltrim($student->wa_ortu, '+');

    if (!$to) return;

    $studentName = $student->name ?? 'Siswa';
    $message = "Halo Orang Tua dari *{$studentName}*.\n"
             . "Anak Anda telah berhasil melakukan absensi hari ini pada pukul *" . now()->format('H:i') . "*.\n"
             . "Terima kasih.";

    Log::info('Isi pesan WA:', ['message' => $message]);
    Log::info('Nomor WA yang dikirim:', ['to' => $to]);

    if (empty(trim($message))) {
        Log::error('Pesan WA kosong. Tidak dikirim.');
        return;
    }

   $response = Http::asForm() // ini penting!!
    ->withOptions([
        'verify' => base_path('cacert.pem')
    ])
    ->withHeaders([
        'Authorization' => $token
    ])
    ->post('https://api.fonnte.com/send', [
        'target' => $to,
        'message' => $message,
        'delay' => 1
    ]);

}
}
