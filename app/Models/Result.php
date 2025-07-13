<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'period_id',
        'leaving_flow',
        'entering_flow',
        'net_flow',
        'rank',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
