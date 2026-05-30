<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $Pencarian  = $request->get('cari');
        $FilterJenis = $request->get('jenis');

        $DataSparepart = Sparepart::query()
            ->when($Pencarian, function ($query) use ($Pencarian) {
                $query->where('nama_sparepart', 'like', "%{$Pencarian}%")
                    ->orWhere('kode_sparepart', 'like', "%{$Pencarian}%")
                    ->orWhere('kategori', 'like', "%{$Pencarian}%");
            })
            ->when($FilterJenis, function ($query) use ($FilterJenis) {
                $query->where('jenis_kendaraan', $FilterJenis);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $TotalSparepart = Sparepart::count();
        $StokMenipis    = Sparepart::whereColumn('stok', '<=', 'stok_minimum')->where('stok', '>', 0)->count();
        $StokHabis      = Sparepart::where('stok', '<=', 0)->count();

        return view('sparepart.index', compact(
            'DataSparepart', 'Pencarian', 'FilterJenis',
            'TotalSparepart', 'StokMenipis', 'StokHabis'
        ));
    }

    public function create()
    {
        $DaftarJenis    = Sparepart::daftarJenis();
        $DaftarKategori = Sparepart::daftarKategori();
        $DaftarSatuan   = Sparepart::daftarSatuan();
        $KodeBaru       = 'SP-' . strtoupper(uniqid());

        return view('sparepart.create', compact('DaftarJenis', 'DaftarKategori', 'DaftarSatuan', 'KodeBaru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sparepart' => 'required|string|max:20|unique:sparepart,kode_sparepart',
            'nama_sparepart' => 'required|string|max:100',
            'kategori'       => 'required|string|max:50',
            'jenis_kendaraan'=> 'required|in:Motor,Mobil,Semua',
            'merk'           => 'nullable|string|max:50',
            'stok'           => 'required|integer|min:0',
            'stok_minimum'   => 'required|integer|min:0',
            'harga_beli'     => 'required|numeric|min:0',
            'harga_jual'     => 'required|numeric|min:0',
            'satuan'         => 'required|string|max:20',
            'keterangan'     => 'nullable|string',
        ], [
            'kode_sparepart.unique' => 'Kode sparepart sudah digunakan.',
            'harga_jual.min'        => 'Harga jual tidak boleh negatif.',
        ]);

        Sparepart::create($request->all());

        return redirect()->route('sparepart.index')
            ->with('sukses', 'Data sparepart berhasil ditambahkan!');
    }

    public function show(Sparepart $sparepart)
    {
        return view('sparepart.show', compact('sparepart'));
    }

    public function edit(Sparepart $sparepart)
    {
        $DaftarJenis    = Sparepart::daftarJenis();
        $DaftarKategori = Sparepart::daftarKategori();
        $DaftarSatuan   = Sparepart::daftarSatuan();

        return view('sparepart.edit', compact('sparepart', 'DaftarJenis', 'DaftarKategori', 'DaftarSatuan'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'kode_sparepart' => 'required|string|max:20|unique:sparepart,kode_sparepart,' . $sparepart->id,
            'nama_sparepart' => 'required|string|max:100',
            'kategori'       => 'required|string|max:50',
            'jenis_kendaraan'=> 'required|in:Motor,Mobil,Semua',
            'merk'           => 'nullable|string|max:50',
            'stok'           => 'required|integer|min:0',
            'stok_minimum'   => 'required|integer|min:0',
            'harga_beli'     => 'required|numeric|min:0',
            'harga_jual'     => 'required|numeric|min:0',
            'satuan'         => 'required|string|max:20',
            'keterangan'     => 'nullable|string',
        ]);

        $sparepart->update($request->all());

        return redirect()->route('sparepart.index')
            ->with('sukses', 'Data sparepart berhasil diperbarui!');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();

        return redirect()->route('sparepart.index')
            ->with('sukses', 'Data sparepart berhasil dihapus!');
    }
}