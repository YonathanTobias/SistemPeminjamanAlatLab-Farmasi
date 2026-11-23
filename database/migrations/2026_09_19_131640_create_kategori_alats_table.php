<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('kategori_alats')) {
            Schema::create('kategori_alats', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kategori')->unique();
                $table->string('ikon')->default('bi-grid-fill');
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });

            $defaultCategories = [
                [
                    'nama_kategori' => 'Teknologi & Formulasi Sediaan',
                    'ikon' => 'bi-capsule-pill',
                    'deskripsi' => 'Alat pencetak tablet, mortir stamper, viskometer, homogenizer, friability & uji disintegrasi sediaan farmasi.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_kategori' => 'Kimia Farmasi & Instrumental',
                    'ikon' => 'bi-droplet-half',
                    'deskripsi' => 'Spektrofotometer UV-Vis, pH meter, hotplate magnetic stirrer, buret titrasi, oven pengering, dan refraktometer.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_kategori' => 'Farmakognosi & Fitokimia Herbal',
                    'ikon' => 'bi-flower1',
                    'deskripsi' => 'Rotary evaporator vacuum, ekstraktor sokletasi, chamber bejana KLT, lampu UV analisis noda, dan perkolator.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_kategori' => 'Farmakologi & Toksikologi',
                    'ikon' => 'bi-heart-pulse-fill',
                    'deskripsi' => 'Plethysmometer edema, rotarod motorik, hot plate analgesiometer, jarum sonde oral mencit, dan kandang metabolik.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_kategori' => 'Mikrobiologi & Uji Sterilitas',
                    'ikon' => 'bi-virus',
                    'deskripsi' => 'Laminar air flow (LAF), autoklaf sterilisasi basah, inkubator mikroorganisme, colony counter digital, dan mikroskop.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_kategori' => 'Glassware & Alat Ukur Presisi',
                    'ikon' => 'bi-eyedropper',
                    'deskripsi' => 'Micropipette adjustable, labu takar volumetrik kelas A, pipet volume gondok, gelas ukur, dan piknometer kaca.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('kategori_alats')->insert($defaultCategories);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_alats');
    }
};
