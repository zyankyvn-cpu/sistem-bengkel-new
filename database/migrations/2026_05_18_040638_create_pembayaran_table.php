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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran', 20)->unique();
            $table->foreignId('servis_id')->constrained('servis')->onDelete('restrict');
            $table->date('tanggal_bayar');
            $table->decimal('total_biaya_jasa', 12, 2)->default(0);
            $table->decimal('total_biaya_sparepart', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->decimal('jumlah_bayar', 12, 2)->default(0);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('metode_bayar', ['Tunai', 'Transfer', 'Debit'])->default('Tunai');
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');
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
        Schema::dropIfExists('pembayaran');
    }
};
