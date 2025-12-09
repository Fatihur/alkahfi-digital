<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\ProfilSekolah;
use App\Models\Slider;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $profil = ProfilSekolah::getProfil();
        $sliders = Slider::active()->get();
        $beritaTerbaru = Berita::published()->latest('tanggal_publikasi')->take(6)->get();
        $galeriTerbaru = Galeri::published()->orderBy('urutan')->take(8)->get();

        return view('landing.index', compact('profil', 'sliders', 'beritaTerbaru', 'galeriTerbaru'));
    }

    public function profil()
    {
        $profil = ProfilSekolah::getProfil();

        return view('landing.profil', compact('profil'));
    }

    public function berita(Request $request)
    {
        $query = Berita::published();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('konten', 'like', "%{$request->search}%");
            });
        }

        $berita = $query->latest('tanggal_publikasi')->paginate(9);
        $profil = ProfilSekolah::getProfil();

        return view('landing.berita', compact('berita', 'profil'));
    }

    public function beritaDetail($slug)
    {
        $berita = Berita::where('slug', $slug)->published()->firstOrFail();
        $berita->incrementViews();
        
        $beritaLainnya = Berita::published()
            ->where('id', '!=', $berita->id)
            ->latest('tanggal_publikasi')
            ->take(4)
            ->get();
        $profil = ProfilSekolah::getProfil();

        return view('landing.berita-detail', compact('berita', 'beritaLainnya', 'profil'));
    }

    public function galeri(Request $request)
    {
        $query = Galeri::published();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $galeri = $query->orderBy('urutan')->paginate(12);
        $profil = ProfilSekolah::getProfil();

        return view('landing.galeri', compact('galeri', 'profil'));
    }

    public function kontak()
    {
        $profil = ProfilSekolah::getProfil();

        return view('landing.kontak', compact('profil'));
    }
}
