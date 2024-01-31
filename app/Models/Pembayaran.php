<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function barang() {
        return $this->belongsTo(Barang::class);
    }

    protected $fillable = [
        'user_id',
        'barang_id',
        'jumlah_pesanan',
        'harga_pesanan',
        'diskon',
        'total_harga',
        'metode'
    ];
}
