<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama', 'supplier_id', 'harga_beli', 'harga_jual', 'stok'
    ];
}
