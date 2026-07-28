<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    protected $fillable = [
        'judul', 'kode_promo', 'deskripsi', 'tipe', 'nilai',
        'min_pembelian', 'tanggal_mulai', 'tanggal_selesai',
        'is_active', 'gambar'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    public function isBerlaku()
    {
        $today = Carbon::today();
        return $this->is_active
            && $today->gte($this->tanggal_mulai)
            && $today->lte($this->tanggal_selesai);
    }
}