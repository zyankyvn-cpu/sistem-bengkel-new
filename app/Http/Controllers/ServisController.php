<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\Kendaraan;
use App\Models\Mekanik;
use Illuminate\Http\Request;
use App\Mail\ServisSelesaiMail;
use Illuminate\Support\Facades\Mail;

class ServisController extends Controller
{
    public function index(Request $request)
    {
        $Pencarian    = $request->get('cari');
        $FilterStatus = $request->get('status');

        $DataServis = Servis::with(['kendaraan', 'mekanik'])
            ->when($Pencarian, function ($query) use ($Pencarian) {
                $query->where('kode_servis', 'like', "%{$Pencarian}%")
                    ->orWhereHas('kendaraan', fn($q) => $q->where('plat_nomor', 'like', "%{$Pencarian}%")
                        ->orWhere('nama_pemilik', 'like', "%{$Pencarian}%"));
            })
            ->when($FilterStatus, fn($query) => $query->where('status', $FilterStatus))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $TotalServis  = Servis::count();
        $Antrian      = Servis::where('status', 'Antrian')->count();
        $Proses       = Servis::where('status', 'Proses')->count();
        $Selesai      = Servis::where('status', 'Selesai')->count();

        return view('servis.index', compact(
            'DataServis', 'Pencarian', 'FilterStatus',
            'TotalServis', 'Antrian', 'Proses', 'Selesai'
        ));
    }

    public function create()
    {
        $DaftarKendaraan = Kendaraan::orderBy('nama_pemilik')->get();
        $DaftarMekanik   = Mekanik::where('status', 'Aktif')->orderBy('nama_mekanik')->get();
        $DaftarStatus    = Servis::daftarStatus();
        $KodeBaru        = 'SRV-' . date('Ymd') . '-' . str_pad(Servis::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

        return view('servis.create', compact('DaftarKendaraan', 'DaftarMekanik', 'DaftarStatus', 'KodeBaru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_servis'    => 'required|string|max:20|unique:servis,kode_servis',
            'kendaraan_id'   => 'required|exists:kendaraan,id',
            'mekanik_id'     => 'required|exists:mekanik,id',
            'tanggal_servis' => 'required|date',
            'keluhan'        => 'required|string',
            'diagnosa'       => 'nullable|string',
            'status'         => 'required|in:Antrian,Proses,Selesai,Dibatalkan',
            'biaya_jasa'     => 'required|numeric|min:0',
            'catatan'        => 'nullable|string',
        ]);

        Servis::create($request->all());

        return redirect()->route('servis.index')
            ->with('sukses', 'Data servis berhasil ditambahkan!');
    }

    public function show(Servis $servis)
    {
        $servis->load(['kendaraan', 'mekanik']);
        return view('servis.show', compact('servis'));
    }

    public function edit(Servis $servis)
    {
        $DaftarKendaraan = Kendaraan::orderBy('nama_pemilik')->get();
        $DaftarMekanik   = Mekanik::where('status', 'Aktif')->orderBy('nama_mekanik')->get();
        $DaftarStatus    = Servis::daftarStatus();

        return view('servis.edit', compact('servis', 'DaftarKendaraan', 'DaftarMekanik', 'DaftarStatus'));
    }

    public function update(Request $request, Servis $servis)
    {
        $request->validate([
            'kode_servis'    => 'required|string|max:20|unique:servis,kode_servis,' . $servis->id,
            'kendaraan_id'   => 'required|exists:kendaraan,id',
            'mekanik_id'     => 'required|exists:mekanik,id',
            'tanggal_servis' => 'required|date',
            'keluhan'        => 'required|string',
            'diagnosa'       => 'nullable|string',
            'status'         => 'required|in:Antrian,Proses,Selesai,Dibatalkan',
            'biaya_jasa'     => 'required|numeric|min:0',
            'catatan'        => 'nullable|string',
        ]);

        $servis->update($request->all());

        // Kirim email kalau status jadi Selesai
        if ($servis->status === 'Selesai' && $servis->kendaraan->email_pemilik) {
            Mail::to($servis->kendaraan->email_pemilik)
                ->send(new ServisSelesaiMail($servis));
        }

        return redirect()->route('servis.index')
            ->with('sukses', 'Data servis berhasil diperbarui!');
     }
    

    public function destroy(Servis $servis)
    {
        $servis->delete();

        return redirect()->route('servis.index')
            ->with('sukses', 'Data servis berhasil dihapus!');
    }
}