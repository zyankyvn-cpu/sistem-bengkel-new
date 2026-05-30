<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    public function index(Request $request)
    {
        $Pencarian = $request->get('cari');

        $DataMekanik = Mekanik::query()
            ->when($Pencarian, function ($query) use ($Pencarian) {
                $query->where('nama_mekanik', 'like', "%{$Pencarian}%")
                    ->orWhere('kode_mekanik', 'like', "%{$Pencarian}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $TotalMekanik  = Mekanik::count();
        $MekanikAktif  = Mekanik::where('status', 'Aktif')->count();

        return view('mekanik.index', compact('DataMekanik', 'Pencarian', 'TotalMekanik', 'MekanikAktif'));
    }

    public function create()
    {
        $DaftarSpesialisasi = Mekanik::daftarSpesialisasi();
        $DaftarStatus       = Mekanik::daftarStatus();
        $KodeBaru           = 'MK-' . str_pad(Mekanik::count() + 1, 3, '0', STR_PAD_LEFT);

        return view('mekanik.create', compact('DaftarSpesialisasi', 'DaftarStatus', 'KodeBaru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mekanik'      => 'required|string|max:20|unique:mekanik,kode_mekanik',
            'nama_mekanik'      => 'required|string|max:100',
            'no_telepon'        => 'required|string|max:20',
            'spesialisasi'      => 'required|in:Motor,Mobil,Keduanya',
            'status'            => 'required|in:Aktif,Tidak Aktif',
            'tanggal_bergabung' => 'required|date',
            'pengalaman_tahun'  => 'required|integer|min:0|max:50',
            'catatan'           => 'nullable|string',
        ]);

        Mekanik::create($request->all());

        return redirect()->route('mekanik.index')
            ->with('sukses', 'Data mekanik berhasil ditambahkan!');
    }

    public function edit(Mekanik $mekanik)
    {
        $DaftarSpesialisasi = Mekanik::daftarSpesialisasi();
        $DaftarStatus       = Mekanik::daftarStatus();

        return view('mekanik.edit', compact('mekanik', 'DaftarSpesialisasi', 'DaftarStatus'));
    }

    public function update(Request $request, Mekanik $mekanik)
    {
        $request->validate([
            'kode_mekanik'      => 'required|string|max:20|unique:mekanik,kode_mekanik,' . $mekanik->id,
            'nama_mekanik'      => 'required|string|max:100',
            'no_telepon'        => 'required|string|max:20',
            'spesialisasi'      => 'required|in:Motor,Mobil,Keduanya',
            'status'            => 'required|in:Aktif,Tidak Aktif',
            'tanggal_bergabung' => 'required|date',
            'pengalaman_tahun'  => 'required|integer|min:0|max:50',
            'catatan'           => 'nullable|string',
        ]);

        $mekanik->update($request->all());

        return redirect()->route('mekanik.index')
            ->with('sukses', 'Data mekanik berhasil diperbarui!');
    }

    public function destroy(Mekanik $mekanik)
    {
        $mekanik->delete();

        return redirect()->route('mekanik.index')
            ->with('sukses', 'Data mekanik berhasil dihapus!');
    }
}