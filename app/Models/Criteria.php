<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $preference_function
 * @property float|null $q
 * @property float|null $p_threshold
 * @property \Illuminate\Database\Eloquent\Collection $weights
 */
class Criteria extends Model
{
    protected $fillable = [
        'name',
        'type',
        'p_threshold',
        'priority_value',
    ];

    public function weights()
    {
        return $this->hasMany(Weight::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
