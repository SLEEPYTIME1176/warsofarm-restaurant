<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'telepon',
        'tanggal',
        'waktu',
        'jumlah_orang',
        'catatan',
        'status',
        'alasan_batal',
    ];
}