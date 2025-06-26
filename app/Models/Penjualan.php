<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'nama_customer', 'total', 'tanggal'
    ];

    public function items()
    {
        return $this->hasMany(PenjualanItem::class);
    }
}
