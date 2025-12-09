<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\KategoriTagihan;
use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@alkahfi.digital',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Bendahara User
        User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@alkahfi.digital',
            'password' => Hash::make('password'),
            'role' => 'bendahara',
            'is_active' => true,
        ]);

        // Create sample Wali Santri
        User::create([
            'name' => 'Ahmad Wali',
            'email' => 'wali@alkahfi.digital',
            'password' => Hash::make('password'),
            'role' => 'wali_santri',
            'no_hp' => '081234567890',
            'is_active' => true,
        ]);

        // Create Kelas
        $kelasList = ['VII A', 'VII B', 'VIII A', 'VIII B', 'IX A', 'IX B'];
        foreach ($kelasList as $index => $namaKelas) {
            Kelas::create([
                'nama_kelas' => $namaKelas,
                'tingkat' => explode(' ', $namaKelas)[0],
                'is_active' => true,
            ]);
        }

        // Create Angkatan
        $tahunSekarang = date('Y');
        for ($i = 0; $i < 3; $i++) {
            $tahun = $tahunSekarang - $i;
            Angkatan::create([
                'tahun_angkatan' => $tahun . '/' . ($tahun + 1),
                'nama_angkatan' => 'Angkatan ' . $tahun,
                'is_active' => true,
            ]);
        }

        // Create Kategori Tagihan
        $kategoriList = [
            ['nama_kategori' => 'SPP Bulanan', 'deskripsi' => 'Tagihan SPP bulanan reguler'],
            ['nama_kategori' => 'Uang Gedung', 'deskripsi' => 'Biaya pembangunan dan perawatan gedung'],
            ['nama_kategori' => 'Seragam', 'deskripsi' => 'Biaya seragam santri'],
            ['nama_kategori' => 'Kegiatan', 'deskripsi' => 'Biaya kegiatan ekstrakurikuler'],
        ];
        foreach ($kategoriList as $kategori) {
            KategoriTagihan::create(array_merge($kategori, ['is_active' => true]));
        }

        // Create Pengaturan
        $pengaturanList = [
            ['kunci' => 'nama_sekolah', 'nilai' => 'Pondok Pesantren Al-Hikmah', 'grup' => 'umum'],
            ['kunci' => 'alamat_sekolah', 'nilai' => 'Jl. Pendidikan No. 123, Kota', 'grup' => 'umum'],
            ['kunci' => 'telepon_sekolah', 'nilai' => '021-1234567', 'grup' => 'umum'],
            ['kunci' => 'email_sekolah', 'nilai' => 'info@alhikmah.sch.id', 'grup' => 'umum'],
            ['kunci' => 'nominal_spp_default', 'nilai' => '500000', 'grup' => 'keuangan'],
            ['kunci' => 'denda_per_hari', 'nilai' => '5000', 'grup' => 'keuangan'],
            ['kunci' => 'hari_pengingat_jatuh_tempo', 'nilai' => '3', 'grup' => 'notifikasi'],
        ];
        foreach ($pengaturanList as $p) {
            Pengaturan::create($p);
        }

        // Call SantriSeeder
        $this->call(SantriSeeder::class);

        // Call TagihanSeeder
        $this->call(TagihanSeeder::class);
    }
}
