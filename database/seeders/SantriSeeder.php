<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SantriSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = Kelas::all();
        $angkatanList = Angkatan::all();

        if ($kelasList->isEmpty() || $angkatanList->isEmpty()) {
            $this->command->warn('Kelas atau Angkatan belum tersedia. Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        $santriData = [
            ['nis' => '2024001', 'nama_lengkap' => 'Muhammad Rizki Pratama', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '2010-05-15', 'alamat' => 'Jl. Merdeka No. 10, Jakarta Selatan', 'wali' => ['name' => 'Budi Pratama', 'email' => 'budi.pratama@email.com', 'no_hp' => '081111111001']],
            ['nis' => '2024002', 'nama_lengkap' => 'Aisyah Putri Rahayu', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '2010-08-22', 'alamat' => 'Jl. Asia Afrika No. 25, Bandung', 'wali' => ['name' => 'Rahayu Dewi', 'email' => 'rahayu.dewi@email.com', 'no_hp' => '081111111002']],
            ['nis' => '2024003', 'nama_lengkap' => 'Ahmad Fauzan', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Surabaya', 'tanggal_lahir' => '2010-03-10', 'alamat' => 'Jl. Pahlawan No. 5, Surabaya', 'wali' => ['name' => 'Hasan Fauzi', 'email' => 'hasan.fauzi@email.com', 'no_hp' => '081111111003']],
            ['nis' => '2024004', 'nama_lengkap' => 'Siti Nurhaliza', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Yogyakarta', 'tanggal_lahir' => '2010-11-30', 'alamat' => 'Jl. Malioboro No. 88, Yogyakarta', 'wali' => ['name' => 'Nurul Hidayah', 'email' => 'nurul.hidayah@email.com', 'no_hp' => '081111111004']],
            ['nis' => '2024005', 'nama_lengkap' => 'Dimas Arya Wijaya', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Semarang', 'tanggal_lahir' => '2010-07-18', 'alamat' => 'Jl. Pandanaran No. 15, Semarang', 'wali' => ['name' => 'Wijaya Kusuma', 'email' => 'wijaya.kusuma@email.com', 'no_hp' => '081111111005']],
            ['nis' => '2024006', 'nama_lengkap' => 'Fatimah Azzahra', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Medan', 'tanggal_lahir' => '2010-09-05', 'alamat' => 'Jl. Gatot Subroto No. 45, Medan', 'wali' => ['name' => 'Abdul Rahman', 'email' => 'abdul.rahman@email.com', 'no_hp' => '081111111006']],
            ['nis' => '2023001', 'nama_lengkap' => 'Rizky Maulana', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Makassar', 'tanggal_lahir' => '2009-04-12', 'alamat' => 'Jl. Sudirman No. 20, Makassar', 'wali' => ['name' => 'Maulana Ibrahim', 'email' => 'maulana.ibrahim@email.com', 'no_hp' => '081111111007']],
            ['nis' => '2023002', 'nama_lengkap' => 'Nabila Safitri', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Palembang', 'tanggal_lahir' => '2009-06-25', 'alamat' => 'Jl. Musi Raya No. 33, Palembang', 'wali' => ['name' => 'Safitri Wulandari', 'email' => 'safitri.wulandari@email.com', 'no_hp' => '081111111008']],
            ['nis' => '2023003', 'nama_lengkap' => 'Ilham Pratama', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Denpasar', 'tanggal_lahir' => '2009-01-08', 'alamat' => 'Jl. Bypass Ngurah Rai No. 100, Bali', 'wali' => ['name' => 'Made Pratama', 'email' => 'made.pratama@email.com', 'no_hp' => '081111111009']],
            ['nis' => '2023004', 'nama_lengkap' => 'Zahra Amelia', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Pontianak', 'tanggal_lahir' => '2009-12-20', 'alamat' => 'Jl. Gajah Mada No. 50, Pontianak', 'wali' => ['name' => 'Ahmad Zainal', 'email' => 'ahmad.zainal@email.com', 'no_hp' => '081111111010']],
            ['nis' => '2022001', 'nama_lengkap' => 'Farhan Hakim', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Malang', 'tanggal_lahir' => '2008-02-14', 'alamat' => 'Jl. Ijen No. 75, Malang', 'wali' => ['name' => 'Hakim Setiawan', 'email' => 'hakim.setiawan@email.com', 'no_hp' => '081111111011']],
            ['nis' => '2022002', 'nama_lengkap' => 'Aulia Rahma', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Bogor', 'tanggal_lahir' => '2008-10-03', 'alamat' => 'Jl. Pajajaran No. 60, Bogor', 'wali' => ['name' => 'Rahmat Hidayat', 'email' => 'rahmat.hidayat@email.com', 'no_hp' => '081111111012']],
        ];

        foreach ($santriData as $index => $data) {
            // Create wali user
            $wali = User::create([
                'name' => $data['wali']['name'],
                'email' => $data['wali']['email'],
                'password' => Hash::make('password'),
                'role' => 'wali_santri',
                'no_hp' => $data['wali']['no_hp'],
                'is_active' => true,
            ]);

            // Assign kelas and angkatan based on NIS year
            $tahunMasuk = substr($data['nis'], 0, 4);
            $kelasIndex = $index % $kelasList->count();
            $angkatanIndex = match ($tahunMasuk) {
                '2024' => 0,
                '2023' => 1,
                '2022' => 2,
                default => 0,
            };

            // Create santri
            $santri = Santri::create([
                'nis' => $data['nis'],
                'nama_lengkap' => $data['nama_lengkap'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'alamat' => $data['alamat'],
                'kelas_id' => $kelasList[$kelasIndex]->id,
                'angkatan_id' => $angkatanList[$angkatanIndex]->id ?? $angkatanList->first()->id,
                'tanggal_masuk' => now(),
                'status' => 'aktif',
            ]);

            // Link wali to santri
            WaliSantri::create([
                'user_id' => $wali->id,
                'santri_id' => $santri->id,
                'hubungan' => collect(['ayah', 'ibu', 'wali'])->random(),
            ]);
        }

        // Link existing wali@alkahfi.digital to first santri if exists
        $existingWali = User::where('email', 'wali@alkahfi.digital')->first();
        $firstSantri = Santri::first();
        if ($existingWali && $firstSantri) {
            WaliSantri::firstOrCreate([
                'user_id' => $existingWali->id,
                'santri_id' => $firstSantri->id,
            ], [
                'hubungan' => 'wali',
            ]);
        }

        $this->command->info('Berhasil membuat ' . count($santriData) . ' santri dengan wali masing-masing.');
    }
}
