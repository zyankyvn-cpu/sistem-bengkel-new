<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sparepart', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sparepart', 20)->unique();
            $table->string('nama_sparepart', 100);
            $table->string('kategori', 50);
            $table->enum('jenis_kendaraan', ['Motor', 'Mobil', 'Semua']);
            $table->string('merk', 50)->nullable();
            $table->integer('stok');
            $table->integer('stok_minimum')->default(5);
            $table->decimal('harga_beli', 12, 2);
            $table->decimal('harga_jual', 12, 2);
            $table->string('satuan', 20)->default('pcs');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sparepart');
    }
};