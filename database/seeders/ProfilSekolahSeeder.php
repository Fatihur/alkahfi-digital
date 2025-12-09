<?php

namespace Database\Seeders;

use App\Models\ProfilSekolah;
use Illuminate\Database\Seeder;

class ProfilSekolahSeeder extends Seeder
{
    public function run(): void
    {
        ProfilSekolah::create([
            'nama_sekolah' => 'Pondok Pesantren Al-Kahfi',
            'npsn' => '12345678',
            'alamat' => 'Jl. Pendidikan No. 123, Kota, Provinsi',
            'telepon' => '(021) 1234567',
            'email' => 'info@alkahfi.sch.id',
            'website' => 'https://alkahfi.sch.id',
            'visi' => 'Mewujudkan generasi Qurani yang berilmu, berakhlak mulia, dan berprestasi dalam kehidupan bermasyarakat.',
            'misi' => "1. Menyelenggarakan pendidikan berbasis Al-Quran dan Sunnah\n2. Membentuk karakter santri yang berakhlak mulia\n3. Mengembangkan potensi akademik dan non-akademik santri\n4. Membekali santri dengan keterampilan hidup yang berguna\n5. Menciptakan lingkungan belajar yang kondusif dan islami",
            'sejarah' => 'Pondok Pesantren Al-Kahfi didirikan dengan visi menciptakan generasi muslim yang berkualitas. Berawal dari sebuah musholla kecil, kini telah berkembang menjadi lembaga pendidikan yang memiliki ratusan santri dan berbagai fasilitas modern.',
            'kepala_sekolah' => 'KH. Muhammad Amin, S.Pd.I., M.Pd.',
            'kata_sambutan' => 'Assalamualaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi Pondok Pesantren Al-Kahfi. Kami berkomitmen untuk memberikan pendidikan terbaik bagi putra-putri Anda. Dengan kurikulum yang memadukan ilmu agama dan umum, kami yakin dapat mencetak generasi yang siap menghadapi tantangan zaman dengan tetap berpegang teguh pada nilai-nilai Islam. Wassalamualaikum Warahmatullahi Wabarakatuh.',
            'sosial_media' => [
                'facebook' => null,
                'instagram' => null,
                'youtube' => null,
                'twitter' => null,
            ],
        ]);
    }
}
