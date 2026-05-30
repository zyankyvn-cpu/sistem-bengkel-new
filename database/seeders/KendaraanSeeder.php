<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kendaraan;

class KendaraanSeeder extends Seeder
{
    public function run()
    {
        $DataKendaraan = [
            [
                'plat_nomor'      => 'D 1234 ABC',
                'nama_pemilik'    => 'Budi Santoso',
                'no_telepon'      => '081234567890',
                'jenis_kendaraan' => 'Motor',
                'merk'            => 'Honda',
                'model'           => 'Beat',
                'tahun_kendaraan' => 2021,
                'warna'           => 'Hitam',
                'catatan'         => null,
            ],
            [
                'plat_nomor'      => 'D 5678 XYZ',
                'nama_pemilik'    => 'Siti Rahayu',
                'no_telepon'      => '085678912345',
                'jenis_kendaraan' => 'Mobil',
                'merk'            => 'Toyota',
                'model'           => 'Avanza',
                'tahun_kendaraan' => 2019,
                'warna'           => 'Putih',
                'catatan'         => 'Servis rutin tiap 3 bulan',
            ],
            [
                'plat_nomor'      => 'Z 9012 DEF',
                'nama_pemilik'    => 'Agus Permana',
                'no_telepon'      => '087812345678',
                'jenis_kendaraan' => 'Motor',
                'merk'            => 'Yamaha',
                'model'           => 'NMAX',
                'tahun_kendaraan' => 2022,
                'warna'           => 'Biru',
                'catatan'         => null,
            ],
            [
                'plat_nomor'      => 'B 3456 GHI',
                'nama_pemilik'    => 'Dewi Kurniawati',
                'no_telepon'      => '082198765432',
                'jenis_kendaraan' => 'Mobil',
                'merk'            => 'Honda',
                'model'           => 'Brio',
                'tahun_kendaraan' => 2020,
                'warna'           => 'Merah',
                'catatan'         => null,
            ],
            [
                'plat_nomor'      => 'D 7890 JKL',
                'nama_pemilik'    => 'Rudi Hartono',
                'no_telepon'      => '089555554321',
                'jenis_kendaraan' => 'Motor',
                'merk'            => 'Suzuki',
                'model'           => 'GSX',
                'tahun_kendaraan' => 2023,
                'warna'           => 'Abu-abu',
                'catatan'         => 'Ganti oli tiap 2 bulan',
            ],
            [
                'plat_nomor'      => 'E 1111 MNO',
                'nama_pemilik'    => 'Rina Marlina',
                'no_telepon'      => '081311112222',
                'jenis_kendaraan' => 'Mobil',
                'merk'            => 'Suzuki',
                'model'           => 'Ertiga',
                'tahun_kendaraan' => 2018,
                'warna'           => 'Silver',
                'catatan'         => null,
            ],
            [
                'plat_nomor'      => 'T 2222 PQR',
                'nama_pemilik'    => 'Dani Pratama',
                'no_telepon'      => '085722223333',
                'jenis_kendaraan' => 'Motor',
                'merk'            => 'Kawasaki',
                'model'           => 'Ninja',
                'tahun_kendaraan' => 2020,
                'warna'           => 'Hijau',
                'catatan'         => null,
            ],
        ];

        foreach ($DataKendaraan as $data) {
            Kendaraan::create($data);
        }
    }
}