<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'code', 'name'
    ];

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class,"class_id");
    }
}
