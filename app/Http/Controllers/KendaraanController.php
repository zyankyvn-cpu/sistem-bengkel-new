<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $Pencarian = $request->get('cari');

        $DataKendaraan = Kendaraan::query()
            ->when($Pencarian, function ($query) use ($Pencarian) {
                $query->where('plat_nomor', 'like', "%{$Pencarian}%")
                    ->orWhere('nama_pemilik', 'like', "%{$Pencarian}%")
                    ->orWhere('merk', 'like', "%{$Pencarian}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kendaraan.index', compact('DataKendaraan', 'Pencarian'));
    }

    public function create()
    {
        $DaftarJenis = Kendaraan::daftarJenis();
        return view('kendaraan.create', compact('DaftarJenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor'       => 'required|string|max:20|unique:kendaraan,plat_nomor',
            'nama_pemilik'     => 'required|string|max:100',
            'no_telepon'       => 'required|string|max:20',
            'jenis_kendaraan'  => 'required|in:Motor,Mobil',
            'merk'             => 'required|string|max:50',
            'model'            => 'required|string|max:50',
            'tahun_kendaraan'  => 'required|digits:4|integer|min:1990|max:' . date('Y'),
            'warna'            => 'required|string|max:30',
            'catatan'          => 'nullable|string',
        ], [
            'plat_nomor.unique'    => 'Plat nomor sudah terdaftar.',
            'tahun_kendaraan.min'  => 'Tahun minimal 1990.',
            'tahun_kendaraan.max'  => 'Tahun tidak boleh melebihi tahun sekarang.',
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('kendaraan.index')
            ->with('sukses', 'Data kendaraan berhasil ditambahkan!');
    }

    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        $DaftarJenis = Kendaraan::daftarJenis();
        return view('kendaraan.edit', compact('kendaraan', 'DaftarJenis'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'plat_nomor'       => 'required|string|max:20|unique:kendaraan,plat_nomor,' . $kendaraan->id,
            'nama_pemilik'     => 'required|string|max:100',
            'no_telepon'       => 'required|string|max:20',
            'jenis_kendaraan'  => 'required|in:Motor,Mobil',
            'merk'             => 'required|string|max:50',
            'model'            => 'required|string|max:50',
            'tahun_kendaraan'  => 'required|digits:4|integer|min:1990|max:' . date('Y'),
            'warna'            => 'required|string|max:30',
            'catatan'          => 'nullable|string',
        ]);

        $kendaraan->update($request->all());

        return redirect()->route('kendaraan.index')
            ->with('sukses', 'Data kendaraan berhasil diperbarui!');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')
            ->with('sukses', 'Data kendaraan berhasil dihapus!');
    }
}