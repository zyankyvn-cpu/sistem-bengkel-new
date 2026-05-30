<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor', 20)->unique();
            $table->string('nama_pemilik', 100);
            $table->string('no_telepon', 20);
            $table->enum('jenis_kendaraan', ['Motor', 'Mobil']);
            $table->string('merk', 50);
            $table->string('model', 50);
            $table->year('tahun_kendaraan');
            $table->string('warna', 30);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kendaraan');
    }
};
