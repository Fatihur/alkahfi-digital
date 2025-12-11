<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with('createdBy');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $pengumuman = $query->latest()->get();

        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'prioritas' => ['required', 'in:rendah,normal,tinggi'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['created_by'] = auth()->id();

        $pengumuman = Pengumuman::create($validated);

        LogAktivitas::log('Tambah Pengumuman', 'pengumuman', "Menambahkan pengumuman: {$pengumuman->judul}");

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'prioritas' => ['required', 'in:rendah,normal,tinggi'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $pengumuman->update($validated);

        LogAktivitas::log('Update Pengumuman', 'pengumuman', "Mengupdate pengumuman: {$pengumuman->judul}");

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        LogAktivitas::log('Hapus Pengumuman', 'pengumuman', "Menghapus pengumuman: {$pengumuman->judul}");

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
