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
        Schema::create('sampah_masuk_nasabahs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_jenis_sampah');
            $table->decimal('harga_nasabah');
            $table->decimal('berat');
            $table->decimal('rupiah');
            $table->boolean('validasi');
            $table->string('no_tabungan');
            $table->integer('id_agen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampah_masuk_nasabahs');
    }
};
