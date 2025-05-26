<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAttendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'student_attendances';

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',

    ];

    protected $fillable = ['student_id', 'class_id', 'academic_year_id', 'status', 'date', 'clock_in', 'clock_out'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', "id");
    }
}
