<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'supplier_id', 'nama', 'stok', 'satuan', 'harga_beli', 'harga_jual'
    ];
}
