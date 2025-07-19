<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property int|null $class_id
 * @property string $name
 * @property string $gender
 * @property string $level
 * @property string $major
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Score[] $scores
 * @property-read \App\Models\SchoolClass|null $schoolClass
 */
class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'name',
        'gender',
        'level',
        'major',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
