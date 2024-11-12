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
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item', 250);
            $table->integer('qty');
            $table->integer('belanja');
            $table->integer('ongkir');
            $table->integer('total');
            $table->integer('net');
            $table->integer('10%');
            $table->integer('penawaran');
            $table->integer('untung');
            $table->integer('untung belanja');
            $table->integer('ariba');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran');
    }
};
