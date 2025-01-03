<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $fillable = ['id', 'alamat', 'nama_perusahaan', 'no_hp', 'npwp'];

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
