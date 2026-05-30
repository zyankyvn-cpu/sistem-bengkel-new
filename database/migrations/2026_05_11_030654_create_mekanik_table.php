<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mekanik', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mekanik', 20)->unique();
            $table->string('nama_mekanik', 100);
            $table->string('no_telepon', 20);
            $table->enum('spesialisasi', ['Motor', 'Mobil', 'Keduanya']);
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->date('tanggal_bergabung');
            $table->integer('pengalaman_tahun')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mekanik');
    }
};