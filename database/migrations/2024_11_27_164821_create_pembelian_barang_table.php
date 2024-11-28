<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelian_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item', 250);
            $table->integer('qty');
            $table->string('satuan', 100);
            $table->integer('harga_item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_pembelian_barang');
    }
};
