<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'academic_years';

    protected $fillable = [
        'name', 'start_date', 'end_date', 'description', 'status', 'semester'
    ];

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }
}
