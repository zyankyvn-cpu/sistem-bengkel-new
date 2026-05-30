<x-mail::message>
# Servis Kendaraan Selesai

Yth. **{{ $servis->kendaraan->nama_pemilik }}**,

Servis kendaraan Anda telah selesai dikerjakan. Berikut detailnya:

<x-mail::table>
| Detail | Info |
|:-------|:-----|
| Plat Nomor | {{ $servis->kendaraan->plat_nomor }} |
| Keluhan | {{ $servis->keluhan }} |
| Mekanik | {{ $servis->mekanik->nama_mekanik }} |
| Status | Selesai ✅ |
</x-mail::table>

Silakan datang ke bengkel untuk mengambil kendaraan Anda.

Terima kasih telah mempercayakan kendaraan Anda kepada kami.

Salam,<br>
**{{ config('app.name') }}**
</x-mail::message>