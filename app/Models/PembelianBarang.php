<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBarang extends Model
{
    use HasFactory;

    protected $table = 'pembelian_barang';
    protected $fillable = ['id', 'nama_item', 'qty', 'satuan', 'harga_item'];
}
