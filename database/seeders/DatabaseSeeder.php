<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AlatLab;
use App\Models\KategoriAlat;
use App\Models\Ruangan;
use App\Models\PeminjamanLab;
use App\Models\PeminjamanLabDetail;
use App\Models\PeminjamanRuangan;
use App\Models\PengaturanLab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database for Program Studi S1 Farmasi.
     */
    public function run(): void
    {
        // 0. Pengaturan Default Laboratorium S1 Farmasi
        PengaturanLab::getPengaturan();

        // 1. Akun Admin IT & Petugas Laboran
        User::updateOrCreate(
            ['email' => 'it@stikes.ac.id'],
            [
                'name' => 'Administrator IT Kampus',
                'password' => Hash::make('admin123'),
                'role' => 'admin_it',
            ]
        );

        User::updateOrCreate(
            ['email' => 'laboran@stikes.ac.id'],
            [
                'name' => 'Petugas Laboran Farmasi',
                'password' => Hash::make('admin123'),
                'role' => 'laboran',
            ]
        );

        // 2. Kategori Master Laboratorium S1 Farmasi
        $kategoris = [
            [
                'nama_kategori' => 'Teknologi & Formulasi Sediaan',
                'ikon' => 'bi-capsule-pill',
                'deskripsi' => 'Alat pencetak tablet, mortir stamper, viskometer, homogenizer, friability & uji disintegrasi sediaan farmasi.',
            ],
            [
                'nama_kategori' => 'Kimia Farmasi & Instrumental',
                'ikon' => 'bi-droplet-half',
                'deskripsi' => 'Spektrofotometer UV-Vis, pH meter, hotplate magnetic stirrer, buret titrasi, oven pengering, dan refraktometer.',
            ],
            [
                'nama_kategori' => 'Farmakognosi & Fitokimia Herbal',
                'ikon' => 'bi-flower1',
                'deskripsi' => 'Rotary evaporator vacuum, ekstraktor sokletasi, chamber bejana KLT, lampu UV analisis noda, dan perkolator.',
            ],
            [
                'nama_kategori' => 'Farmakologi & Toksikologi',
                'ikon' => 'bi-heart-pulse-fill',
                'deskripsi' => 'Plethysmometer edema, rotarod motorik, hot plate analgesiometer, jarum sonde oral mencit, dan kandang metabolik.',
            ],
            [
                'nama_kategori' => 'Mikrobiologi & Uji Sterilitas',
                'ikon' => 'bi-virus',
                'deskripsi' => 'Laminar air flow (LAF), autoklaf sterilisasi basah, inkubator mikroorganisme, colony counter digital, dan mikroskop.',
            ],
            [
                'nama_kategori' => 'Glassware & Alat Ukur Presisi',
                'ikon' => 'bi-eyedropper',
                'deskripsi' => 'Micropipette adjustable, labu takar volumetrik kelas A, pipet volume gondok, gelas ukur, dan piknometer kaca.',
            ],
        ];

        foreach ($kategoris as $kat) {
            KategoriAlat::updateOrCreate(
                ['nama_kategori' => $kat['nama_kategori']],
                $kat
            );
        }

        // 3. Master Data Peralatan Laboratorium S1 Farmasi STIKES Panti Waluya
        $alats = [
            // Kategori 1: Teknologi & Formulasi Sediaan
            [
                'kode_alat' => 'TEK-001',
                'nama_alat' => 'Lumpang dan Alu Porselen (Mortar & Pestle) 13cm & 16cm',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 25,
                'stok_tersedia' => 22,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-002',
                'nama_alat' => 'Timbangan Analitik Digital Presisi 4 Desimal (0.0001g) Ohaus',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 8,
                'stok_tersedia' => 7,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-003',
                'nama_alat' => 'Timbangan Gram Halus Manual & Anak Timbang Standar Farmakope',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 15,
                'stok_tersedia' => 14,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-004',
                'nama_alat' => 'Alat Cetak Tablet Single Punch Manual Farmasi',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-005',
                'nama_alat' => 'Tablet Hardness Tester Digital (Alat Uji Kekerasan Tablet)',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-006',
                'nama_alat' => 'Tablet Friability Tester Dual Drum (Uji Kerapuhan Tablet)',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-007',
                'nama_alat' => 'Disintegration Tester (Alat Uji Waktu Hancur Tablet)',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 3,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-008',
                'nama_alat' => 'Viskometer Brookfield & Viskometer Ostwald Bola Jatuh',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 5,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TEK-009',
                'nama_alat' => 'High-Speed Homogenizer Emulsi & Suspensi Farmasi',
                'kategori' => 'Teknologi & Formulasi Sediaan',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
            ],

            // Kategori 2: Kimia Farmasi & Instrumental
            [
                'kode_alat' => 'KIM-001',
                'nama_alat' => 'Spektrofotometer UV-Vis Double Beam Shimadzu UV-1800',
                'kategori' => 'Kimia Farmasi & Instrumental',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'KIM-002',
                'nama_alat' => 'pH Meter Digital Benchtop Hanna Instruments HI-2211',
                'kategori' => 'Kimia Farmasi & Instrumental',
                'stok_total' => 10,
                'stok_tersedia' => 9,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'KIM-003',
                'nama_alat' => 'Buret Titrasi Makro 50ml Amber/Bening + Statif & Klem Double',
                'kategori' => 'Kimia Farmasi & Instrumental',
                'stok_total' => 25,
                'stok_tersedia' => 22,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'KIM-004',
                'nama_alat' => 'Hotplate Magnetic Stirrer Digital IKA C-MAG HS 7',
                'kategori' => 'Kimia Farmasi & Instrumental',
                'stok_total' => 12,
                'stok_tersedia' => 10,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'KIM-005',
                'nama_alat' => 'Oven Pengering Simplisia & Alat Gelas Memmert (Drying Oven)',
                'kategori' => 'Kimia Farmasi & Instrumental',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'KIM-006',
                'nama_alat' => 'Water Bath Thermostatic Multi-Hole Laboratorium Kimia',
                'kategori' => 'Kimia Farmasi & Instrumental',
                'stok_total' => 6,
                'stok_tersedia' => 5,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'KIM-007',
                'nama_alat' => 'Refraktometer Abbe Analog / Digital (Uji Indeks Bias)',
                'kategori' => 'Kimia Farmasi & Instrumental',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'kondisi' => 'Baik',
            ],

            // Kategori 3: Farmakognosi & Fitokimia Herbal
            [
                'kode_alat' => 'FTO-001',
                'nama_alat' => 'Rotary Evaporator Vacuum Heidolph (Destilasi Pelarut Ekstrak)',
                'kategori' => 'Farmakognosi & Fitokimia Herbal',
                'stok_total' => 3,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'FTO-002',
                'nama_alat' => 'Alat Ekstraksi Sokletasi (Soxhlet Extractor Set) 500ml Pyrex',
                'kategori' => 'Farmakognosi & Fitokimia Herbal',
                'stok_total' => 8,
                'stok_tersedia' => 7,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'FTO-003',
                'nama_alat' => 'Bejana Kromatografi Lapis Tipis (Chamber KLT Kaca Camag)',
                'kategori' => 'Farmakognosi & Fitokimia Herbal',
                'stok_total' => 15,
                'stok_tersedia' => 13,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'FTO-004',
                'nama_alat' => 'Lampu UV Analis Noda KLT 254 nm & 366 nm (UV Cabinet Viewer)',
                'kategori' => 'Farmakognosi & Fitokimia Herbal',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'FTO-005',
                'nama_alat' => 'Perkolator Kaca Kerucut Ekstraksi Simplisia 1000ml',
                'kategori' => 'Farmakognosi & Fitokimia Herbal',
                'stok_total' => 10,
                'stok_tersedia' => 9,
                'kondisi' => 'Baik',
            ],

            // Kategori 4: Farmakologi & Toksikologi
            [
                'kode_alat' => 'TOX-001',
                'nama_alat' => 'Plethysmometer Digital (Uji Anti-inflamasi Edema Kaki Tikus)',
                'kategori' => 'Farmakologi & Toksikologi',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TOX-002',
                'nama_alat' => 'Rotarod Test System (Uji Efek Relaksasi Otot & Motorik)',
                'kategori' => 'Farmakologi & Toksikologi',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TOX-003',
                'nama_alat' => 'Hot Plate Analgesiometer Ugo Basile (Uji Efek Analgetik)',
                'kategori' => 'Farmakologi & Toksikologi',
                'stok_total' => 3,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TOX-004',
                'nama_alat' => 'Jarum Sonde Oral Mencit & Tikus Stainless Steel Bulat (Set)',
                'kategori' => 'Farmakologi & Toksikologi',
                'stok_total' => 30,
                'stok_tersedia' => 28,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'TOX-005',
                'nama_alat' => 'Kandang Hewan Uji Metabolisme Mencit & Tikus Acuan GLP',
                'kategori' => 'Farmakologi & Toksikologi',
                'stok_total' => 15,
                'stok_tersedia' => 15,
                'kondisi' => 'Baik',
            ],

            // Kategori 5: Mikrobiologi & Uji Sterilitas
            [
                'kode_alat' => 'MIC-001',
                'nama_alat' => 'Laminar Air Flow (LAF) Vertical Clean Bench (Aseptis Sediaan)',
                'kategori' => 'Mikrobiologi & Uji Sterilitas',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'MIC-002',
                'nama_alat' => 'Autoklaf Elektrik Sterilisasi Media & Alat Basah All American',
                'kategori' => 'Mikrobiologi & Uji Sterilitas',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'MIC-003',
                'nama_alat' => 'Inkubator Mikrobiologi Suhu Presisi Memmert IN-55',
                'kategori' => 'Mikrobiologi & Uji Sterilitas',
                'stok_total' => 4,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'MIC-004',
                'nama_alat' => 'Digital Colony Counter dengan Pen Sensor & Kaca Pembesar',
                'kategori' => 'Mikrobiologi & Uji Sterilitas',
                'stok_total' => 6,
                'stok_tersedia' => 5,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'MIC-005',
                'nama_alat' => 'Mikroskop Binokuler Olympus CX-23 LED Iluminasi',
                'kategori' => 'Mikrobiologi & Uji Sterilitas',
                'stok_total' => 12,
                'stok_tersedia' => 11,
                'kondisi' => 'Baik',
            ],

            // Kategori 6: Glassware & Alat Ukur Presisi
            [
                'kode_alat' => 'GLS-001',
                'nama_alat' => 'Micropipette Adjustable 100 - 1000 µL Socorex + Tip Box',
                'kategori' => 'Glassware & Alat Ukur Presisi',
                'stok_total' => 15,
                'stok_tersedia' => 13,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'GLS-002',
                'nama_alat' => 'Labu Takar Volumetrik 100ml Kelas A Pyrex Borosilikat',
                'kategori' => 'Glassware & Alat Ukur Presisi',
                'stok_total' => 35,
                'stok_tersedia' => 32,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'GLS-003',
                'nama_alat' => 'Pipet Volume / Pipet Gondok 10ml & 25ml + Rubber Bulb Filler',
                'kategori' => 'Glassware & Alat Ukur Presisi',
                'stok_total' => 30,
                'stok_tersedia' => 28,
                'kondisi' => 'Baik',
            ],
            [
                'kode_alat' => 'GLS-004',
                'nama_alat' => 'Piknometer Kaca 25ml & 50ml Standar Penentuan Bobot Jenis',
                'kategori' => 'Glassware & Alat Ukur Presisi',
                'stok_total' => 20,
                'stok_tersedia' => 19,
                'kondisi' => 'Baik',
            ],
        ];

        $alatModels = [];
        foreach ($alats as $alat) {
            $alatModels[$alat['kode_alat']] = AlatLab::updateOrCreate(
                ['kode_alat' => $alat['kode_alat']],
                $alat
            );
        }

        // 4. Master Ruangan Praktikum & Laboratorium Farmasi
        $ruangans = [
            [
                'kode_ruangan' => 'R-FAR-01',
                'nama_ruangan' => 'Laboratorium Teknologi Farmasi & Formulasi Sediaan',
                'lokasi' => 'Gedung C Lantai 2',
                'kapasitas' => 40,
                'fasilitas' => 'Mesin Cetak Tablet, Timbangan Analitik, Dissolution Tester, Friability & Hardness Tester, Lemari Asam, AC & Multimedia.',
                'status' => 'Tersedia',
            ],
            [
                'kode_ruangan' => 'R-FAR-02',
                'nama_ruangan' => 'Laboratorium Kimia Farmasi & Analisis Instrumental',
                'lokasi' => 'Gedung C Lantai 2',
                'kapasitas' => 40,
                'fasilitas' => 'Spektrofotometer UV-Vis, pH Meter Benchtop, Meja Titrasi Keramik Tahan Asam, Hotplate Stirrer, Oven Memmert, Fume Hood.',
                'status' => 'Tersedia',
            ],
            [
                'kode_ruangan' => 'R-FAR-03',
                'nama_ruangan' => 'Laboratorium Farmakognosi & Fitokimia Bahan Alam',
                'lokasi' => 'Gedung C Lantai 3',
                'kapasitas' => 35,
                'fasilitas' => 'Rotary Evaporator Vacuum, Alat Sokletasi, UV Cabinet Viewer KLT, Perkolator Kaca, Mikroskop Simplisia, Rak Herbarium.',
                'status' => 'Tersedia',
            ],
            [
                'kode_ruangan' => 'R-FAR-04',
                'nama_ruangan' => 'Laboratorium Farmakologi & Toksikologi Eksperimental',
                'lokasi' => 'Gedung C Lantai 3',
                'kapasitas' => 30,
                'fasilitas' => 'Plethysmometer Edema, Rotarod Test System, Hot Plate Analgesiometer, Meja Bedah Hewan Coba, Ruang Kandang Hewan Terkontrol.',
                'status' => 'Tersedia',
            ],
            [
                'kode_ruangan' => 'R-FAR-05',
                'nama_ruangan' => 'Laboratorium Mikrobiologi Farmasi & Ruang Aseptis',
                'lokasi' => 'Gedung C Lantai 3',
                'kapasitas' => 30,
                'fasilitas' => 'Laminar Air Flow (LAF) Cabinet, Autoklaf Elektrik, Inkubator Bakteri & Jamur, Colony Counter Digital, Mikroskop Binokuler LED.',
                'status' => 'Tersedia',
            ],
            [
                'kode_ruangan' => 'R-FAR-06',
                'nama_ruangan' => 'Apotek Simulasi, Dispensing & Konseling Farmasi Klinis',
                'lokasi' => 'Gedung A Lantai 1',
                'kapasitas' => 25,
                'fasilitas' => 'Rak Obat & Etalase Standar Apotek, Meja Peracikan Kapsul/Puyer, Ruang Konseling Pasien Khusus, POS Komputer & Billing Farmasi.',
                'status' => 'Tersedia',
            ],
        ];

        $ruanganModels = [];
        foreach ($ruangans as $ruang) {
            $ruanganModels[$ruang['kode_ruangan']] = Ruangan::updateOrCreate(
                ['kode_ruangan' => $ruang['kode_ruangan']],
                $ruang
            );
        }

        // 5. Sampel Data Transaksi Peminjaman Alat Farmasi
        $transaksis = [
            [
                'header' => [
                    'kode_transaksi' => 'TRX-20261120-001',
                    'nama_peminjam' => 'Nadia Safitri, S.Farm.',
                    'nim_nip' => '202304012',
                    'prodi' => 'S1 Farmasi',
                    'keperluan' => 'Praktikum Formulasi Sediaan Padat (Granulasi & Evaluasi Tablet Paracetamol)',
                    'tgl_pinjam' => Carbon::now()->subDays(3)->format('Y-m-d'),
                    'tgl_kembali_rencana' => Carbon::now()->subDays(2)->format('Y-m-d'),
                    'tgl_kembali_realisasi' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
                    'status' => 'Dikembalikan',
                    'catatan' => 'Peminjaman alat formulasi tablet. Mortir dan stamper dikembalikan bersih dan kering.',
                ],
                'items' => [
                    ['alat_id' => $alatModels['TEK-001']->id, 'qty' => 2],
                    ['alat_id' => $alatModels['TEK-002']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['TEK-005']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['TEK-006']->id, 'qty' => 1],
                ]
            ],
            [
                'header' => [
                    'kode_transaksi' => 'TRX-20261121-002',
                    'nama_peminjam' => 'apt. Dimas Prasetyo, M.Farm.',
                    'nim_nip' => '1991051502',
                    'prodi' => 'S1 Farmasi',
                    'keperluan' => 'Penelitian Ekstraksi & Fraksinasi Senyawa Antioksidan Daun Kelor',
                    'tgl_pinjam' => Carbon::now()->subDays(1)->format('Y-m-d'),
                    'tgl_kembali_rencana' => Carbon::now()->addDays(2)->format('Y-m-d'),
                    'tgl_kembali_realisasi' => null,
                    'status' => 'Disetujui',
                    'catatan' => 'Digunakan di Lab Fitokimia Gedung C Lantai 3.',
                ],
                'items' => [
                    ['alat_id' => $alatModels['FTO-001']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['FTO-002']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['FTO-003']->id, 'qty' => 2],
                    ['alat_id' => $alatModels['GLS-002']->id, 'qty' => 3],
                ]
            ],
            [
                'header' => [
                    'kode_transaksi' => 'TRX-20261122-003',
                    'nama_peminjam' => 'Rizky Firmansyah',
                    'nim_nip' => '202304033',
                    'prodi' => 'S1 Farmasi',
                    'keperluan' => 'Uji Efek Analgetik Ekstrak Jahe Merah pada Hewan Coba Mencit',
                    'tgl_pinjam' => Carbon::now()->format('Y-m-d'),
                    'tgl_kembali_rencana' => Carbon::now()->addDays(1)->format('Y-m-d'),
                    'tgl_kembali_realisasi' => null,
                    'status' => 'Disetujui',
                    'catatan' => 'Praktikum Farmakologi modul nyeri dan analgesia.',
                ],
                'items' => [
                    ['alat_id' => $alatModels['TOX-003']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['TOX-004']->id, 'qty' => 2],
                    ['alat_id' => $alatModels['GLS-001']->id, 'qty' => 1],
                ]
            ],
            [
                'header' => [
                    'kode_transaksi' => 'TRX-20261123-004',
                    'nama_peminjam' => 'Aulia Rahmadani',
                    'nim_nip' => '202404055',
                    'prodi' => 'S1 Farmasi',
                    'keperluan' => 'Uji Aktivitas Antibakteri Sediaan Gel Antiseptik Alami',
                    'tgl_pinjam' => Carbon::now()->format('Y-m-d'),
                    'tgl_kembali_rencana' => Carbon::now()->addDays(2)->format('Y-m-d'),
                    'tgl_kembali_realisasi' => null,
                    'status' => 'Menunggu',
                    'catatan' => 'Meminjam mikropipet dan inkubator mikrobiologi untuk inkubasi 24 jam.',
                ],
                'items' => [
                    ['alat_id' => $alatModels['MIC-003']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['MIC-004']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['MIC-005']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['GLS-001']->id, 'qty' => 1],
                ]
            ],
            [
                'header' => [
                    'kode_transaksi' => 'TRX-20261123-005',
                    'nama_peminjam' => 'Kevin Pratama',
                    'nim_nip' => '202204005',
                    'prodi' => 'S1 Farmasi',
                    'keperluan' => 'Titrasi Asidimetri Penetapan Kadar Asam Asetilsalisilat (Aspirin)',
                    'tgl_pinjam' => Carbon::now()->format('Y-m-d'),
                    'tgl_kembali_rencana' => Carbon::now()->addDays(1)->format('Y-m-d'),
                    'tgl_kembali_realisasi' => null,
                    'status' => 'Menunggu',
                    'catatan' => 'Praktikum Kimia Farmasi Kuantitatif kelompok 3.',
                ],
                'items' => [
                    ['alat_id' => $alatModels['KIM-002']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['KIM-003']->id, 'qty' => 2],
                    ['alat_id' => $alatModels['KIM-004']->id, 'qty' => 1],
                    ['alat_id' => $alatModels['GLS-003']->id, 'qty' => 2],
                ]
            ],
        ];

        foreach ($transaksis as $trx) {
            $peminjaman = PeminjamanLab::updateOrCreate(
                ['kode_transaksi' => $trx['header']['kode_transaksi']],
                $trx['header']
            );
            // Bersihkan detail lama jika ada
            PeminjamanLabDetail::where('peminjaman_lab_id', $peminjaman->id)->delete();
            foreach ($trx['items'] as $item) {
                PeminjamanLabDetail::create([
                    'peminjaman_lab_id' => $peminjaman->id,
                    'alat_lab_id' => $item['alat_id'],
                    'jumlah_pinjam' => $item['qty'],
                ]);
            }
        }

        // 6. Sampel Data Peminjaman Ruangan Farmasi
        $bookingRuangans = [
            [
                'kode_transaksi' => 'RNG-20261124-001',
                'ruangan_id' => $ruanganModels['R-FAR-01']->id,
                'nama_peminjam' => 'apt. Dewi Anggraeni, M.Farm.',
                'nim_nip' => '1987091201',
                'prodi' => 'S1 Farmasi',
                'keperluan' => 'Praktikum Teknologi Sediaan Padat (Kelas Farmasi A)',
                'tgl_pinjam' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'status' => 'Disetujui',
                'catatan' => 'Praktikum pembuatan tablet granulasi basah 35 mahasiswa.',
            ],
            [
                'kode_transaksi' => 'RNG-20261125-002',
                'ruangan_id' => $ruanganModels['R-FAR-02']->id,
                'nama_peminjam' => 'Naufal Hidayat',
                'nim_nip' => '202304018',
                'prodi' => 'S1 Farmasi',
                'keperluan' => 'Penelitian Skripsi: Analisis Spektrofotometri Senyawa Flavonoid',
                'tgl_pinjam' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '16:00:00',
                'status' => 'Menunggu',
                'catatan' => 'Menggunakan instrumen Spektrofotometer UV-Vis Shimadzu.',
            ],
        ];

        foreach ($bookingRuangans as $br) {
            PeminjamanRuangan::updateOrCreate(
                ['kode_transaksi' => $br['kode_transaksi']],
                $br
            );
        }
    }
}
