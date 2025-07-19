<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property int|null $class_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'class_id',
        'name',
        'role',
        'email',
        'password',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function isHomeroomTeacher(): bool
    {
        return $this->role === 'homeroom_teacher';
    }

    public function isAdministration(): bool
    {
        return $this->role === 'administration';
    }

    public function isHeadmaster(): bool
    {
        return $this->role === 'headmaster';
    }

    public function isStaffStudent(): bool
    {
        return $this->role === 'staff_student';
    }

    /**
     * Role label accessor, contoh "Wali Kelas" untuk "homeroom_teacher".
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'homeroom_teacher' => 'Wali Kelas',
            'administration' => 'Staff Tata Usaha',
            'headmaster' => 'Kepala Sekolah',
            'staff_student' => 'Wakil Kesiswaan',
            default => 'Jabatan Tidak Diketahui',
        };
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
