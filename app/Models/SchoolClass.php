<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Karena nama model tidak sama dengan nama tabel

    protected $fillable = [
        'name',
    ];
    
     public function teacher()
    {
        return $this->hasOne(User::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
