<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * // tambahkan properti lain sesuai tabel
 */
class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
