<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman Ruangan Laboratorium</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.5pt;
            color: #222;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Resmi */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .kop-table td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }
        .kop-title {
            text-align: center;
        }
        .kop-title h2 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-title h4 {
            margin: 2px 0 3px 0;
            font-size: 10.5pt;
            font-weight: bold;
            color: #0284c7;
            text-transform: uppercase;
        }
        .kop-title p {
            margin: 0;
            font-size: 7.5pt;
            color: #555;
        }

        /* Document Title */
        .doc-title {
            text-align: center;
            margin: 10px 0 12px 0;
        }
        .doc-title h3 {
            margin: 0;
            font-size: 10.5pt;
            text-transform: uppercase;
            text-decoration: underline;
            color: #111;
        }
        .doc-title p {
            margin: 2px 0 0 0;
            font-size: 7.5pt;
            color: #666;
        }

        /* Main Data Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: bold;
            font-size: 7.5pt;
            text-transform: uppercase;
            border: 1px solid #cbd5e1;
            padding: 6px 4px;
            text-align: center;
        }
        table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 6px;
            font-size: 7.5pt;
            vertical-align: top;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }

        /* Badge Status */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 7pt;
            font-weight: bold;
            text-align: center;
        }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-primary { background-color: #e0f2fe; color: #075985; }
        .badge-warning { background-color: #fef9c3; color: #854d0e; }
        .badge-danger  { background-color: #fee2e2; color: #991b1b; }

        /* Tanda Tangan */
        .ttd-table {
            width: 100%;
            margin-top: 25px;
            border: none;
        }
        .ttd-table td {
            border: none;
            padding: 0;
            vertical-align: top;
            font-size: 8pt;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="kop-table">
        <tr>
            <td style="width: 70px; text-align: center; vertical-align: middle; padding-bottom: 5px;">
                @php
                    $logoFile = public_path($pengaturan->logo_path ?? 'images/logo-stikes.png');
                @endphp
                @if(file_exists($logoFile))
                    <img src="{{ $logoFile }}" height="65" style="object-fit: contain;">
                @endif
            </td>
            <td class="kop-title" style="text-align: center; vertical-align: middle;">
                <h2>{{ $pengaturan->nama_institusi ?? 'STIKES Panti Waluya Malang' }}</h2>
                <h4>{{ $pengaturan->unit_laboratorium ?? 'Unit Laboratorium Farmakologi & Teknologi Farmasi' }} - {{ $pengaturan->nama_prodi ?? 'Prodi S1 Farmasi' }}</h4>
                <p>{{ $pengaturan->alamat_institusi ?? 'Jl. Yulius Usman No.62, Kasin, Kec. Klojen, Kota Malang' }} &bull; Telp: {{ $pengaturan->kontak_lab ?? '(0341) 369003' }}</p>
            </td>
        </tr>
    </table>

    <!-- Judul Laporan -->
    <div class="doc-title">
        <h3>Laporan Rekapitulasi Peminjaman Ruang Laboratorium</h3>
        <p>
            @if(!empty($tahun) && $tahun !== 'all')
                <strong>Periode: Tahun {{ $tahun }}</strong> &bull;
            @else
                <strong>Periode: Semua Tahun (Rekap Lengkap)</strong> &bull;
            @endif
            Dicetak pada: {{ date('d-m-Y H:i') }} WIB &bull; Total Transaksi: {{ $peminjamans->count() }} Data
        </p>
    </div>

    <!-- Tabel Data -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 22px;">No</th>
                <th style="width: 85px;">Kode TRX</th>
                <th style="width: 110px;">Ruang Laboratorium</th>
                <th style="width: 115px;">Peminjam</th>
                <th style="width: 80px;">Program Studi</th>
                <th style="width: 95px;">Jadwal Pemakaian</th>
                <th>Keperluan / Agenda Praktikum</th>
                <th style="width: 65px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="fw-bold text-center">{{ $item->kode_transaksi }}</td>
                <td>
                    <strong>{{ $item->ruangan->nama_ruangan ?? '-' }}</strong><br>
                    <span style="color: #666; font-size: 7pt;">{{ $item->ruangan->kode_ruangan ?? '' }} {{ $item->ruangan->lokasi ? '(' . $item->ruangan->lokasi . ')' : '' }}</span>
                </td>
                <td>
                    <strong>{{ $item->nama_peminjam }}</strong><br>
                    <span style="color: #666; font-size: 7pt;">NIM/NIP: {{ $item->nim_nip }}</span>
                </td>
                <td>{{ $item->prodi }}</td>
                <td class="text-center">
                    <div>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</div>
                    <div style="color: #555; font-size: 7pt;">{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }} WIB</div>
                </td>
                <td>
                    <div>{{ $item->keperluan }}</div>
                    @if($item->catatan)
                        <div style="color: #666; font-size: 7pt; font-style: italic; margin-top: 2px;">Catatan: {{ $item->catatan }}</div>
                    @endif
                </td>
                <td class="text-center">
                    @if($item->status === 'Disetujui')
                        <span class="badge badge-primary">Disetujui</span>
                    @elseif($item->status === 'Selesai')
                        <span class="badge badge-success">Selesai</span>
                    @elseif($item->status === 'Ditolak')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge badge-warning">Menunggu</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 18px; color: #777;">
                    Tidak ada data riwayat peminjaman ruangan pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Lembar Pengesahan / Tanda Tangan -->
    <table class="ttd-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                <p style="margin-bottom: 50px;">
                    {{ $pengaturan->kota_dokumen ?? 'Malang' }}, {{ date('d F Y') }}<br>
                    <strong>Kepala Unit Laboratorium,</strong>
                </p>
                <p style="margin: 0; text-decoration: underline; font-weight: bold;">
                    ( {{ $pengaturan->kepala_lab ?? 'apt. Fransiska Dewi, M.Farm.' }} )
                </p>
                <p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #555;">NIP/NIK. {{ $pengaturan->nip_kepala_lab ?? '-' }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
