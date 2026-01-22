<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_rumah_sakit',
        'alamat',
        'email',
        'telepon'
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}