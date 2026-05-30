<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'plat_nomor',
        'nama_pemilik',
        'email_pemilik',
        'no_telepon',
        'jenis_kendaraan',
        'merk',
        'model',
        'tahun_kendaraan',
        'warna',
        'catatan',
    ];

    // Konstanta jenis kendaraan
    const JENIS_MOTOR = 'Motor';
    const JENIS_MOBIL = 'Mobil';

    public static function daftarJenis(): array
    {
        return [
            self::JENIS_MOTOR => 'Motor',
            self::JENIS_MOBIL => 'Mobil',
        ];
    }
}