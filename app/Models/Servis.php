<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    use HasFactory;

    protected $table = 'servis';

    protected $fillable = [
        'kode_servis',
        'kendaraan_id',
        'mekanik_id',
        'tanggal_servis',
        'keluhan',
        'diagnosa',
        'status',
        'biaya_jasa',
        'catatan',
    ];

    protected $casts = [
        'tanggal_servis' => 'date',
    ];

    // Konstanta status servis
    const STATUS_ANTRIAN   = 'Antrian';
    const STATUS_PROSES    = 'Proses';
    const STATUS_SELESAI   = 'Selesai';
    const STATUS_BATAL     = 'Dibatalkan';

    public static function daftarStatus(): array
    {
        return [
            self::STATUS_ANTRIAN => 'Antrian',
            self::STATUS_PROSES  => 'Proses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_BATAL   => 'Dibatalkan',
        ];
    }

    // Relasi ke Kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    // Relasi ke Mekanik
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_id');
    }

    // Format biaya jasa
    public function getBiayaJasaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya_jasa, 0, ',', '.');
    }
    public function pembayaran()
    {
    return $this->hasOne(Pembayaran::class, 'servis_id');
    }
}