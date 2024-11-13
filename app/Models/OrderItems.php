<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItems extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'jumlah_barang',
        'keterangan',
        'surat_jalan_id',
    ];

    /**
     * Get all of the comments for the OrderItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function surat_jalan(): HasMany
    {
        return $this->hasMany(SuratJalan::class, 'surat_jalan_id', 'id');
    }
}
