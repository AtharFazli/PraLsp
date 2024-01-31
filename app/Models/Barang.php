<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    public function pembayaran() {
        return $this->hasOne(Pembayaran::class);
    }

    protected $fillable = [
        'nama_barang',
        'harga_barang',
        'gambar_barang'
    ];
}
