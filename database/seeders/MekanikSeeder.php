<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mekanik;

class MekanikSeeder extends Seeder
{
    public function run()
    {
        $DataMekanik = [
            ['kode_mekanik' => 'MK-001', 'nama_mekanik' => 'Asep Supriatna', 'no_telepon' => '081234560001', 'spesialisasi' => 'Motor', 'status' => 'Aktif', 'tanggal_bergabung' => '2019-03-01', 'pengalaman_tahun' => 7, 'catatan' => null],
            ['kode_mekanik' => 'MK-002', 'nama_mekanik' => 'Dedi Kurniawan', 'no_telepon' => '081234560002', 'spesialisasi' => 'Mobil', 'status' => 'Aktif', 'tanggal_bergabung' => '2020-06-15', 'pengalaman_tahun' => 5, 'catatan' => null],
            ['kode_mekanik' => 'MK-003', 'nama_mekanik' => 'Rizky Fauzan', 'no_telepon' => '081234560003', 'spesialisasi' => 'Keduanya', 'status' => 'Aktif', 'tanggal_bergabung' => '2021-01-10', 'pengalaman_tahun' => 4, 'catatan' => 'Mekanik terbaik bulan ini'],
            ['kode_mekanik' => 'MK-004', 'nama_mekanik' => 'Hendra Gunawan', 'no_telepon' => '081234560004', 'spesialisasi' => 'Motor', 'status' => 'Tidak Aktif', 'tanggal_bergabung' => '2018-09-20', 'pengalaman_tahun' => 8, 'catatan' => 'Sedang cuti panjang'],
            ['kode_mekanik' => 'MK-005', 'nama_mekanik' => 'Wahyu Pratama', 'no_telepon' => '081234560005', 'spesialisasi' => 'Mobil', 'status' => 'Aktif', 'tanggal_bergabung' => '2022-04-05', 'pengalaman_tahun' => 3, 'catatan' => null],
        ];

        foreach ($DataMekanik as $data) {
            Mekanik::create($data);
        }
    }
}