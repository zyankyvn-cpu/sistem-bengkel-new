<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_servis', 20)->unique();
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('restrict');
            $table->foreignId('mekanik_id')->constrained('mekanik')->onDelete('restrict');
            $table->date('tanggal_servis');
            $table->text('keluhan');
            $table->text('diagnosa')->nullable();
            $table->enum('status', ['Antrian', 'Proses', 'Selesai', 'Dibatalkan'])->default('Antrian');
            $table->decimal('biaya_jasa', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servis');
    }
};