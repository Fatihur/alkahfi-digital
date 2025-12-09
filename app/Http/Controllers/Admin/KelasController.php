<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('santri')->latest()->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:50'],
            'tingkat' => ['nullable', 'string', 'max:20'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $kelas = Kelas::create($validated);

        LogAktivitas::log('Tambah Kelas', 'kelas', "Menambahkan kelas: {$kelas->nama_kelas}");

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        return view('admin.kelas.edit', ['kelas' => $kela]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:50'],
            'tingkat' => ['nullable', 'string', 'max:20'],
            'keterangan' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $kela->update($validated);

        LogAktivitas::log('Update Kelas', 'kelas', "Mengupdate kelas: {$kela->nama_kelas}");

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->santri()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kelas yang masih memiliki santri.');
        }

        LogAktivitas::log('Hapus Kelas', 'kelas', "Menghapus kelas: {$kela->nama_kelas}");

        $kela->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
