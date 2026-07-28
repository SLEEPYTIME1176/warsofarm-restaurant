<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'tanggal',
        'waktu',
        'jumlah_orang',
        'catatan',
        'status',
    ];
}