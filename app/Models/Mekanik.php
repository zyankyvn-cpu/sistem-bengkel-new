<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;

    protected $table = 'mekanik';

    protected $fillable = [
        'kode_mekanik',
        'nama_mekanik',
        'no_telepon',
        'spesialisasi',
        'status',
        'tanggal_bergabung',
        'pengalaman_tahun',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    const STATUS_AKTIF      = 'Aktif';
    const STATUS_TIDAK_AKTIF = 'Tidak Aktif';

    public static function daftarSpesialisasi(): array
    {
        return ['Motor', 'Mobil', 'Keduanya'];
    }

    public static function daftarStatus(): array
    {
        return [
            self::STATUS_AKTIF       => 'Aktif',
            self::STATUS_TIDAK_AKTIF => 'Tidak Aktif',
        ];
    }
}