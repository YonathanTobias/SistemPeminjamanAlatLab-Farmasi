<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\PeminjamanRuangan;
use App\Models\PengaturanLab;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RuanganController extends Controller
{
    // Halaman Publik Daftar Ruangan & Form Booking
    public function indexPublik(Request $request)
    {
        $ruangans = Ruangan::where('status', '!=', 'Tidak Aktif')->get();
        $pengaturan = PengaturanLab::first();

        return view('lab.ruangan', compact('ruangans', 'pengaturan'));
    }

    // Submit Booking Ruangan oleh Pengguna Publik
    public function storeBookingPublik(Request $request)
    {
        // 0. Honeypot Anti-Bot Trap: Jika field terisi, pasti bot scanner otomatis
        if ($request->filled('_hp_security_check') || !empty($request->input('_hp_security_check'))) {
            return back()->with('error', 'Aktivitas otomatisasi (Bot) terdeteksi dan diblokir.');
        }

        $request->validate([
            'ruangan_id'    => 'required|exists:ruangans,id',
            'nama_peminjam' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
            'nim_nip'       => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\.\-\/\_]+$/'],
            'prodi'         => 'required|string|max:100',
            'keperluan'     => 'required|string|max:255',
            'tgl_pinjam'    => 'required|date|after_or_equal:today',
            'jam_mulai'     => 'required',
            'jam_selesai'   => 'required|after:jam_mulai',
            'catatan'       => 'nullable|string|max:500',
        ], [
            'nama_peminjam.regex' => 'Nama peminjam hanya boleh berisi huruf, spasi, titik, koma, tanda petik, dan strip.',
            'nim_nip.regex'       => 'Format NIM / NIP hanya boleh berupa huruf, angka, titik, garis miring, atau strip tanpa karakter aneh.',
        ]);

        // Sanitasi teks dari tag HTML dan karakter berbahaya
        $cleanNama = strip_tags(trim($request->nama_peminjam));
        $cleanNim  = strip_tags(trim($request->nim_nip));
        $cleanProdi = strip_tags(trim($request->prodi));
        $cleanKeperluan = strip_tags(trim($request->keperluan));
        $cleanCatatan = $request->catatan ? strip_tags(trim($request->catatan)) : null;

        // Cek bentrok jadwal ruangan yang sudah Disetujui atau masih Menunggu
        $bentrok = PeminjamanRuangan::where('ruangan_id', $request->ruangan_id)
            ->where('tgl_pinjam', $request->tgl_pinjam)
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($bentrok) {
            return back()->with('error', 'Maaf, ruangan pada tanggal dan jam tersebut sudah diajukan/digunakan peminjam lain. Silakan pilih waktu lain.')->withInput();
        }

        $kodeTransaksi = 'RNG-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        PeminjamanRuangan::create([
            'kode_transaksi' => $kodeTransaksi,
            'ruangan_id'     => $request->ruangan_id,
            'nama_peminjam'  => $cleanNama,
            'nim_nip'        => $cleanNim,
            'prodi'          => $cleanProdi,
            'keperluan'      => $cleanKeperluan,
            'tgl_pinjam'     => $request->tgl_pinjam,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'status'         => 'Menunggu',
            'catatan'        => $cleanCatatan,
        ]);

        return redirect()->route('lab.lacak', ['q' => $kodeTransaksi, 'tab' => 'ruangan'])
            ->with('success', 'Pengajuan peminjaman ruangan berhasil dikirim dengan Kode: ' . $kodeTransaksi . '. Anda dapat langsung melacak statusnya di sini.');
    }

    // Admin: Kelola Master Data Ruangan
    public function adminRuangan()
    {
        $ruangans = Ruangan::withCount('peminjamans')->latest()->paginate(10);
        $pengaturan = PengaturanLab::first();

        return view('admin.ruangan.index', compact('ruangans', 'pengaturan'));
    }

    public function storeRuangan(Request $request)
    {
        $request->validate([
            'kode_ruangan' => 'required|string|unique:ruangans,kode_ruangan|max:50',
            'nama_ruangan' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'required|integer|min:0',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:Tersedia,Perbaikan,Tidak Aktif',
        ]);

        Ruangan::create($request->all());

        return redirect()->route('admin.ruangan.index')->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function updateRuangan(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $request->validate([
            'kode_ruangan' => 'required|string|max:50|unique:ruangans,kode_ruangan,' . $id,
            'nama_ruangan' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'required|integer|min:0',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:Tersedia,Perbaikan,Tidak Aktif',
        ]);

        $ruangan->update($request->all());

        return redirect()->route('admin.ruangan.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroyRuangan($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('admin.ruangan.index')->with('success', 'Data ruangan berhasil dihapus.');
    }

    // Admin: Kelola Booking Ruangan & Update Status
    public function adminPeminjamanRuangan(Request $request)
    {
        // 1. Ambil daftar tahun unik dari transaksi peminjaman ruangan
        $availableYears = PeminjamanRuangan::selectRaw('YEAR(tgl_pinjam) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }
        if (!in_array(date('Y'), $availableYears)) {
            array_unshift($availableYears, date('Y'));
        }

        $selectedYear = $request->query('tahun', date('Y'));

        $query = PeminjamanRuangan::with('ruangan');

        // Filter Tahun Transaksi (default tahun berjalan, kecuali memilih 'all')
        if ($selectedYear !== 'all' && is_numeric($selectedYear)) {
            $query->whereYear('tgl_pinjam', $selectedYear);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_peminjam', 'like', '%' . $request->search . '%')
                  ->orWhere('nim_nip', 'like', '%' . $request->search . '%');
            });
        }

        $peminjamans = $query->latest('tgl_pinjam')->latest('jam_mulai')->paginate(15)->withQueryString();
        $pengaturan = PengaturanLab::getPengaturan();

        return view('admin.ruangan.peminjaman', compact('peminjamans', 'pengaturan', 'availableYears', 'selectedYear'));
    }

    // Admin: Cetak Laporan PDF Peminjaman Ruangan
    public function cetakLaporanPdf(Request $request)
    {
        $query = PeminjamanRuangan::with('ruangan');

        $tahun = $request->input('tahun', $request->input('tahun_ruangan', null));
        if ($tahun && $tahun !== 'all' && is_numeric($tahun)) {
            $query->whereYear('tgl_pinjam', $tahun);
        }

        $tglMulai = $request->input('tgl_mulai', $request->input('tgl_mulai_ruangan', null));
        if ($tglMulai) {
            $query->whereDate('tgl_pinjam', '>=', $tglMulai);
        }

        $tglSelesai = $request->input('tgl_selesai', $request->input('tgl_selesai_ruangan', null));
        if ($tglSelesai) {
            $query->whereDate('tgl_pinjam', '<=', $tglSelesai);
        }

        $status = $request->input('status', $request->input('status_ruangan', null));
        if ($status) {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_peminjam', 'like', '%' . $request->search . '%')
                  ->orWhere('nim_nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }

        $peminjamans = $query->latest('tgl_pinjam')->latest('jam_mulai')->get();
        $pengaturan = PengaturanLab::getPengaturan();

        $pdf = Pdf::loadView('admin.laporan.pdf_ruangan', compact('peminjamans', 'pengaturan', 'tahun'));
        $fileSuffix = ($tahun && $tahun !== 'all') ? '-' . $tahun : '';
        return $pdf->stream('laporan-peminjaman-ruangan' . $fileSuffix . '.pdf');
    }

    public function updateStatusPeminjaman(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak,Selesai',
            'catatan' => 'nullable|string',
        ]);

        $peminjaman = PeminjamanRuangan::findOrFail($id);
        $peminjaman->update([
            'status' => $request->status,
            'catatan' => $request->catatan ?? $peminjaman->catatan,
        ]);

        return back()->with('success', 'Status peminjaman ruangan berhasil diperbarui menjadi: ' . $request->status);
    }
}
