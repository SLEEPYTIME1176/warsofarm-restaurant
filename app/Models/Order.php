<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id', 'kode_order', 'total', 'status', 'catatan',
    'tipe_pesanan', 'nomor_meja', 'metode_pembayaran', 'alasan_batal',
    'cancel_request','alasan_batal_user','kode_promo','diskon'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}