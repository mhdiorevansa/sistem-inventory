<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;
    protected $table = 'penawaran';
    protected $fillable = ['id', 'nama_item', 'qty', 'belanja', 'ongkir', 'total', 'net', '10%', 'penawaran', 'untung', 'untung_belanja', 'ariba'];
}
