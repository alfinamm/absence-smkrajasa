<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Imagick;

class BarcodeController extends Controller
{
    public function downloadBarcode($nisn)
    {
      	
        // Generate barcode HTML
        $student = Student::query()->where('nisn', '=', $nisn)->first();
        $image = asset('storage/images/' . $student->image);
        $logo = asset('assets/images/logo-dark.png');
        
        $pdf = FacadePdf::loadView('student.absenCard', ['student' => $student, 'image' => $image, 'logo' => $logo]);
        $filename = $student->name . ' - ' . $nisn . '.pdf';
		
        // Return the PDF as a download
        return $pdf->download($filename);
        //return view('student.index');
    }
}
