<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servis;

class ServisSeeder extends Seeder
{
    public function run()
    {
        $DataServis = [
            ['kode_servis' => 'SRV-20260101-001', 'kendaraan_id' => 1, 'mekanik_id' => 1, 'tanggal_servis' => '2026-01-10', 'keluhan' => 'Mesin tidak mau hidup', 'diagnosa' => 'Busi mati, perlu diganti', 'status' => 'Selesai', 'biaya_jasa' => 75000, 'catatan' => null],
            ['kode_servis' => 'SRV-20260101-002', 'kendaraan_id' => 2, 'mekanik_id' => 2, 'tanggal_servis' => '2026-01-15', 'keluhan' => 'Rem blong', 'diagnosa' => 'Kampas rem habis', 'status' => 'Selesai', 'biaya_jasa' => 150000, 'catatan' => null],
            ['kode_servis' => 'SRV-20260201-001', 'kendaraan_id' => 3, 'mekanik_id' => 1, 'tanggal_servis' => '2026-02-05', 'keluhan' => 'Oli bocor', 'diagnosa' => null, 'status' => 'Proses', 'biaya_jasa' => 100000, 'catatan' => 'Menunggu sparepart'],
            ['kode_servis' => 'SRV-20260201-002', 'kendaraan_id' => 4, 'mekanik_id' => 3, 'tanggal_servis' => '2026-02-10', 'keluhan' => 'AC tidak dingin', 'diagnosa' => null, 'status' => 'Antrian', 'biaya_jasa' => 0, 'catatan' => null],
            ['kode_servis' => 'SRV-20260301-001', 'kendaraan_id' => 5, 'mekanik_id' => 1, 'tanggal_servis' => '2026-03-01', 'keluhan' => 'Ganti oli rutin', 'diagnosa' => 'Oli perlu diganti', 'status' => 'Antrian', 'biaya_jasa' => 50000, 'catatan' => null],
        ];

        foreach ($DataServis as $data) {
            Servis::create($data);
        }
    }
}