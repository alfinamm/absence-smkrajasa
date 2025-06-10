<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\ReportAttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\ScanQrCodeController;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Milon\Barcode\DNS1D;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [HomeController::class, 'root']);

Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile-update', [UserController::class, 'profileEdit'])->name('user.profile-edit');

    Route::get('/academic-year', [AcademicYearController::class, 'index'])->name('academic-year.index');
    Route::post('/academic-year', [AcademicYearController::class, 'store'])->name('academic-year.store');
    Route::get('/academic-year/{academicYear}', [AcademicYearController::class, 'show'])->name('academic-year.show');
    Route::get('/academic-year/{academicYear}/edit', [AcademicYearController::class, 'edit'])->name('academic-year.edit');
    Route::post('/academic-year/{academicYear}', [AcademicYearController::class, 'update'])->name('academic-year.update');
    Route::delete('/academic-year/{academicYear}', [AcademicYearController::class, 'destroy'])->name('academic-year.destroy');

    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/role/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::get('/class', [ClassController::class, 'index'])->name('class.index');
    Route::post('/class', [ClassController::class, 'store'])->name('class.store');
    Route::get('/class/{class}', [ClassController::class, 'show'])->name('class.show');
    Route::get('/class/{class}/edit', [ClassController::class, 'edit'])->name('class.edit');
    Route::post('/class/{class}', [ClassController::class, 'update'])->name('class.update');
    Route::delete('/class/{class}', [ClassController::class, 'destroy'])->name('class.destroy');

    Route::get('/student', [StudentController::class, 'index'])->name('student.index');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{student}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/student/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/{student}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/student/{student}', [StudentController::class, 'destroy'])->name('student.destroy');
    Route::get('/student/pdf', [StudentController::class, 'pdf'])->name('student.pdf');

    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee/{employee}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::get('/employee/{employee}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employee/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

    Route::get('/user/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/student-attendance', [StudentAttendanceController::class, 'index'])->name('student-attendance.index');
    Route::get('/student-attendance/{class}', [StudentAttendanceController::class, 'show'])->name('student-attendance.show');
    Route::get('/student-attendance/{class}/{student}', [StudentAttendanceController::class, 'edit'])->name('student-attendance.edit');
    Route::post('/student-attendance/{class}/{student}', [StudentAttendanceController::class, 'update'])->name('student-attendance.update');


    Route::get('/report-attendance', [ReportAttendanceController::class, 'index'])->name('report-attendance.index');
    Route::get('/report-attendance/{class}', [ReportAttendanceController::class, 'show'])->name('report-attendance.show');
    Route::get('/report-attendance/{class}/{student} ', [ReportAttendanceController::class, 'showBy'])->name('report-attendance.show.by.student');

    Route::get('/report-attendance-token', [ReportAttendanceController::class, 'showByToken'])->name('report-attendance.show.by.token');

   Route::get('/absence', function () {
    return redirect('http://localhost:8000/scan-qrcode');
    })->name('absence.index');


    Route::get('/scan-qrcode', [ScanQrCodeController::class, 'index'])->name('scan-qrcode.index');
    Route::post('/scan-qrcode', [ScanQrCodeController::class, 'store'])->name('scan-qrcode.store');



    Route::get('/download-barcode/{nisn}', [BarcodeController::class, 'downloadBarcode'])->name('download.barcode');
});

Route::get('/generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Route::post('/import', [StudentController::class, 'import'])->name('students.import');
