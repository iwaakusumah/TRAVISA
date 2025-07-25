<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $student_id
 * @property int $criteria_id
 * @property float|int $value
 * // properti lain sesuai tabel
 */
class Score extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'period_id',
        'criteria_id',
        'value',
    ];
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }
}
