<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sparepart;

class SparepartSeeder extends Seeder
{
    public function run()
    {
        $DataSparepart = [
            ['kode_sparepart' => 'SP-OLI001', 'nama_sparepart' => 'Oli Mesin 4T', 'kategori' => 'Oli & Pelumas', 'jenis_kendaraan' => 'Motor', 'merk' => 'AHM', 'stok' => 50, 'stok_minimum' => 10, 'harga_beli' => 35000, 'harga_jual' => 45000, 'satuan' => 'liter', 'keterangan' => null],
            ['kode_sparepart' => 'SP-OLI002', 'nama_sparepart' => 'Oli Mesin Mobil', 'kategori' => 'Oli & Pelumas', 'jenis_kendaraan' => 'Mobil', 'merk' => 'Castrol', 'stok' => 30, 'stok_minimum' => 5, 'harga_beli' => 80000, 'harga_jual' => 110000, 'satuan' => 'liter', 'keterangan' => null],
            ['kode_sparepart' => 'SP-FLT001', 'nama_sparepart' => 'Filter Udara Motor', 'kategori' => 'Filter', 'jenis_kendaraan' => 'Motor', 'merk' => 'Honda', 'stok' => 25, 'stok_minimum' => 5, 'harga_beli' => 25000, 'harga_jual' => 38000, 'satuan' => 'pcs', 'keterangan' => null],
            ['kode_sparepart' => 'SP-FLT002', 'nama_sparepart' => 'Filter Oli Mobil', 'kategori' => 'Filter', 'jenis_kendaraan' => 'Mobil', 'merk' => 'Toyota', 'stok' => 3, 'stok_minimum' => 5, 'harga_beli' => 45000, 'harga_jual' => 65000, 'satuan' => 'pcs', 'keterangan' => 'Stok hampir habis'],
            ['kode_sparepart' => 'SP-BUS001', 'nama_sparepart' => 'Busi Motor', 'kategori' => 'Busi', 'jenis_kendaraan' => 'Motor', 'merk' => 'NGK', 'stok' => 40, 'stok_minimum' => 10, 'harga_beli' => 18000, 'harga_jual' => 28000, 'satuan' => 'pcs', 'keterangan' => null],
            ['kode_sparepart' => 'SP-REM001', 'nama_sparepart' => 'Kampas Rem Depan', 'kategori' => 'Rem', 'jenis_kendaraan' => 'Semua', 'merk' => null, 'stok' => 0, 'stok_minimum' => 5, 'harga_beli' => 35000, 'harga_jual' => 55000, 'satuan' => 'set', 'keterangan' => 'Stok habis'],
            ['kode_sparepart' => 'SP-AKI001', 'nama_sparepart' => 'Aki Motor', 'kategori' => 'Aki', 'jenis_kendaraan' => 'Motor', 'merk' => 'GS', 'stok' => 15, 'stok_minimum' => 3, 'harga_beli' => 150000, 'harga_jual' => 200000, 'satuan' => 'pcs', 'keterangan' => null],
            ['kode_sparepart' => 'SP-AKI002', 'nama_sparepart' => 'Aki Mobil', 'kategori' => 'Aki', 'jenis_kendaraan' => 'Mobil', 'merk' => 'Yuasa', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 450000, 'harga_jual' => 600000, 'satuan' => 'pcs', 'keterangan' => null],
        ];

        foreach ($DataSparepart as $data) {
            Sparepart::create($data);
        }
    }
}