<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = Galeri::with('createdBy');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $galeri = $query->orderBy('urutan')->get();

        return view('admin.landing.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.landing.galeri.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['required', 'image', 'max:2048'],
            'kategori' => ['required', 'string', 'max:50'],
            'is_published' => ['boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['gambar'] = $request->file('gambar')->store('galeri', 'public');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['created_by'] = auth()->id();
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $galeri = Galeri::create($validated);

        LogAktivitas::log('Tambah Galeri', 'galeri', "Menambahkan galeri: {$galeri->judul}");

        return redirect()->route('admin.landing.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.landing.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'kategori' => ['required', 'string', 'max:50'],
            'is_published' => ['boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($galeri->gambar);
            $validated['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $galeri->update($validated);

        LogAktivitas::log('Update Galeri', 'galeri', "Mengupdate galeri: {$galeri->judul}");

        return redirect()->route('admin.landing.galeri.index')
            ->with('success', 'Galeri berhasil diupdate.');
    }

    public function destroy(Galeri $galeri)
    {
        Storage::disk('public')->delete($galeri->gambar);

        LogAktivitas::log('Hapus Galeri', 'galeri', "Menghapus galeri: {$galeri->judul}");

        $galeri->delete();

        return redirect()->route('admin.landing.galeri.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
