<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItems extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'harga_barang',
        'satuan',
        'jumlah_barang',
        'keterangan',
        'surat_jalan_id',
        'perusahaan_id',
    ];

    /**
     * Get all of the comments for the OrderItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function surat_jalan(): BelongsTo
    {
        return $this->belongsTo(SuratJalan::class, 'surat_jalan_id', 'id');
    }
    /**
     * Get the user that owns the OrderItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id', 'id');
    }
}
