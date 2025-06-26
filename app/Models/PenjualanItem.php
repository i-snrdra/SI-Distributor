<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanItem extends Model
{
    protected $fillable = [
        'penjualan_id', 'product_id', 'qty', 'harga_jual', 'subtotal'
    ];
    public function penjualan() {
        return $this->belongsTo(Penjualan::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
} 