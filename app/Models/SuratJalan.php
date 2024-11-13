<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
