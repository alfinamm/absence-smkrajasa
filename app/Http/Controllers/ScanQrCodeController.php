<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScanQrCodeController extends Controller
{
    /**
     * Form scan QR.
     */
    public function index()
    {
        return view('student-attendance.qr-scan.manual');
    }

    /**
     * Simpan absensi setelah kartu di‑scan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
        ]);

        // pastikan spasi/tanda baca ikut terhapus
        $nisn = trim($request->nisn);

        $student = Student::where('nisn', $nisn)->first();
        if (!$student) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }

        $academicYear = AcademicYear::where('status', 1)->first();
        if (!$academicYear) {
            return back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $today = Carbon::today()->toDateString();

        StudentAttendance::updateOrCreate(
            [
                'student_id'       => $student->id,
                'academic_year_id' => $academicYear->id,
                'date'             => $today,
            ],
            [
                'class_id' => $student->class_id,
                'status'   => 1,
                'clock_in' => now(),
            ]
        );

        // kirim WhatsApp ke orang‑tua
        $this->sendWhatsappNotification($student);

        return back()->with('success', 'Absensi berhasil untuk ' . $student->name);
    }

    /**
     * Kirim notifikasi WhatsApp via Fonnte.
     */
    protected function sendWhatsappNotification(Student $student): void
    {
        $token = 'woUkq1q2WNHhnhe5HLpr';
        $to    = ltrim($student->wa_ortu, '+');

        if (!$to) {
            return; // nomor WA kosong
        }

        $message = "Halo Orang Tua dari *{$student->name}*.\n"
                 . "Anak Anda telah melakukan absensi pada "
                 . now()->format('H:i') . " WIB.\nTerima kasih.";

        // log debug (opsional)
        Log::info('WA message', ['to' => $to, 'body' => $message]);

        Http::asForm()
            ->withOptions(['verify' => base_path('cacert.pem')]) // hilangkan baris ini jika tak perlu SSL bundle
            ->withHeaders(['Authorization' => $token])
            ->post('https://api.fonnte.com/send', [
                'target' => $to,
                'message' => $message,
                'delay'   => 1,
            ]);
    }
}
