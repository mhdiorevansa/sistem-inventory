<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan';
    protected $fillable = [
        'nomor_surat_jalan',
        'nomor_invoice',
        'tanggal',
        'nomor_po',
        'transportasi_kirim',
        'nomor_polisi'
    ];

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'surat_jalan_id', 'id');
    }
}
