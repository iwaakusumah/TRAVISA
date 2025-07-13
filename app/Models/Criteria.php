<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
