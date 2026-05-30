<?php
namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Servis;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $Pencarian = $request->get('cari');

        $DataPembayaran = Pembayaran::with(['servis.kendaraan'])
            ->when($Pencarian, function ($query) use ($Pencarian) {
                $query->where('kode_pembayaran', 'like', "%{$Pencarian}%")
                    ->orWhereHas('servis.kendaraan', fn($q) =>
                        $q->where('plat_nomor', 'like', "%{$Pencarian}%")
                          ->orWhere('nama_pemilik', 'like', "%{$Pencarian}%")
                    );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $TotalPembayaran = Pembayaran::count();
        $TotalLunas      = Pembayaran::where('status', 'Lunas')->count();
        $TotalBelumLunas = Pembayaran::where('status', 'Belum Lunas')->count();

        return view('pembayaran.index', compact(
            'DataPembayaran', 'Pencarian',
            'TotalPembayaran', 'TotalLunas', 'TotalBelumLunas'
        ));
    }

    public function create()
    {
        $DaftarServis  = Servis::with('kendaraan')
            ->whereDoesntHave('pembayaran')
            ->where('status', 'Selesai')
            ->get();
        $DaftarMetode  = Pembayaran::daftarMetode();
        $KodeBaru      = 'PAY-' . date('Ymd') . '-' . str_pad(Pembayaran::count() + 1, 3, '0', STR_PAD_LEFT);

        return view('pembayaran.create', compact('DaftarServis', 'DaftarMetode', 'KodeBaru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pembayaran'      => 'required|string|max:20|unique:pembayaran,kode_pembayaran',
            'servis_id'            => 'required|exists:servis,id',
            'tanggal_bayar'        => 'required|date',
            'total_biaya_jasa'     => 'required|numeric|min:0',
            'total_biaya_sparepart'=> 'required|numeric|min:0',
            'total_bayar'          => 'required|numeric|min:0',
            'jumlah_bayar'         => 'required|numeric|min:0',
            'kembalian'            => 'required|numeric|min:0',
            'metode_bayar'         => 'required|in:Tunai,Transfer,Debit',
            'status'               => 'required|in:Lunas,Belum Lunas',
            'catatan'              => 'nullable|string',
        ]);

        Pembayaran::create($request->all());

        // Update status servis jadi Selesai
        $Servis = Servis::find($request->servis_id);
        $Servis->update(['status' => 'Selesai']);

        return redirect()->route('pembayaran.index')
            ->with('sukses', 'Pembayaran berhasil dicatat!');
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['servis.kendaraan', 'servis.mekanik']);
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function edit(Pembayaran $pembayaran)
    {
        $DaftarMetode = Pembayaran::daftarMetode();
        return view('pembayaran.edit', compact('pembayaran', 'DaftarMetode'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'tanggal_bayar'        => 'required|date',
            'jumlah_bayar'         => 'required|numeric|min:0',
            'kembalian'            => 'required|numeric|min:0',
            'metode_bayar'         => 'required|in:Tunai,Transfer,Debit',
            'status'               => 'required|in:Lunas,Belum Lunas',
            'catatan'              => 'nullable|string',
        ]);

        $pembayaran->update($request->all());

        return redirect()->route('pembayaran.index')
            ->with('sukses', 'Data pembayaran berhasil diperbarui!');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')
            ->with('sukses', 'Data pembayaran berhasil dihapus!');
    }
}