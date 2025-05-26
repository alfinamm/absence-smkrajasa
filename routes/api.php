<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ReportAttendanceController;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Milon\Barcode\DNS1D;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('api')->get('/find-student', [AbsenceController::class, 'checkAbsence']);
Route::middleware('api')->get('/charts/{class}', [ReportAttendanceController::class, 'charts']);
