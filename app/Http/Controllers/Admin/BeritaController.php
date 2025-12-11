<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('createdBy');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $berita = $query->latest()->get();

        return view('admin.landing.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.landing.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'kategori' => ['required', 'string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['judul']);
        
        $count = 1;
        $originalSlug = $validated['slug'];
        while (Berita::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['created_by'] = auth()->id();
        
        if ($validated['is_published']) {
            $validated['tanggal_publikasi'] = now();
        }

        $berita = Berita::create($validated);

        LogAktivitas::log('Tambah Berita', 'berita', "Menambahkan berita: {$berita->judul}");

        return redirect()->route('admin.landing.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.landing.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'kategori' => ['required', 'string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $wasPublished = $berita->is_published;
        $validated['is_published'] = $request->boolean('is_published');
        
        if (!$wasPublished && $validated['is_published']) {
            $validated['tanggal_publikasi'] = now();
        }

        $berita->update($validated);

        LogAktivitas::log('Update Berita', 'berita', "Mengupdate berita: {$berita->judul}");

        return redirect()->route('admin.landing.berita.index')
            ->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        LogAktivitas::log('Hapus Berita', 'berita', "Menghapus berita: {$berita->judul}");

        $berita->delete();

        return redirect()->route('admin.landing.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
