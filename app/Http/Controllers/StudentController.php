<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportStudentsRequest;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $users = User::all();
        $classes = ClassModel::all();
        $students = Student::all();
        return view('student.index', compact('students', 'users', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:students,nisn',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string',
            'wa_ortu' => 'nullable|string|regex:/^\+62\d{9,15}$/', // Validasi nomor WhatsApp dengan awalan +62
            'class_id' => 'required',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // Retrieve the uploaded file from the request
            $filename = $file->getClientOriginalName();

            Storage::putFileAs('public/images', $file, $filename);
        }

        Student::create([
            'nisn' => $request->nisn,
            'image' => $filename,
            'name' => $request->name,
            'wa_ortu' => $request->wa_ortu,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('student.index')->with('success', 'Murid berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        return view('student.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $users = User::all();
        $classes = ClassModel::all();
        return view('student.edit', compact('student', 'users', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nisn' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'nullable|string',
            'wa_ortu' => 'nullable|string|regex:/^\+62\d{9,15}$/', // Validasi nomor WhatsApp dengan awalan +62
            'class_id' => 'nullable',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // Retrieve the uploaded file from the request
            $filename = $file->getClientOriginalName();

            Storage::putFileAs('public/images', $file, $filename);
        }

        $student->nisn = $request->nisn;
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                if ($student->image) {
                    unlink(storage_path() . '/app/public/images/' . $student->image);
                }
                $student->image = $filename;
            }
            $student->name = $request->name;
            $student->wa_ortu = $request->wa_ortu;
            $student->class_id = $request->class_id;
            $student->save();

            DB::commit();

            return redirect()->route('student.index')->with('success', 'Murid berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('student.index')->with('error', 'Terjadi kesalahan.');
        }
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index')->with('success', 'Murid berhasil dihapus.');
    }

    public function pdf(Student $pdf)
    {
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML('<h1>Hello Word!!</h1>');
        $pdf->Output();
    }

    public function import(ImportStudentsRequest $request)
{
    $file = $request->file('file');
    $rows = array_map('str_getcsv', file($file));

    if (empty($rows)) {
        return back()->withErrors(['File CSV kosong atau tidak dapat dibaca.']);
    }

    // Bersihkan header
    $header = array_map('strtolower', array_map('trim', $rows[0]));
$expectedHeader = ['nisn', 'nama', 'kelas', 'wa_ortu'];

$diff = array_diff($expectedHeader, $header);
if (count($diff) > 0) {
    return back()->withErrors([
        'Format header salah. Gunakan header persis: ' . implode(', ', $expectedHeader)
    ]);
}


    unset($rows[0]); // hapus header

    $errors = [];
    foreach ($rows as $index => $row) {
        if (count($row) < 4) continue;

        $data = [
        'nisn' => trim($row[0]),
        'name' => trim($row[1]),
        'class_id' => trim($row[2]),
        'wa_ortu' => '+62' . ltrim(trim($row[3]), '0'),
    ];

        $validator = Validator::make($data, [
        'nisn' => 'required|string|max:255|unique:students,nisn',
        'name' => 'required|string|max:255',
        'wa_ortu' => ['nullable', 'regex:/^\+62\d{9,15}$/'],
        'class_id' => 'required|exists:classes,id',
    ]);


        if ($validator->fails()) {
            $errors["Baris " . ($index + 2)] = $validator->errors()->all();
            continue;
        }

        Student::create([
        'nisn' => $data['nisn'],
        'name' => $data['name'],
        'image' => null,
        'wa_ortu' => $data['wa_ortu'],
        'class_id' => $data['class_id'],
    ]);

    }

    if (!empty($errors)) {
        return back()->withErrors($errors)->withInput();
    }

    return back()->with('success', 'Berhasil mengimpor murid.');
}

}