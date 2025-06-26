<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianItem extends Model
{
    protected $fillable = [
        'pembelian_id', 'product_id', 'qty', 'harga_beli', 'subtotal'
    ];
    public function pembelian() {
        return $this->belongsTo(Pembelian::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
} 