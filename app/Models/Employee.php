<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nik',
        'name',
        'phone',
        'position',
        'address',
        'user_id',
        'basic_salary',
        'department',
    ];
    // Satu karyawan bisa punya banyak slip gaji
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    // Relasi ke absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
