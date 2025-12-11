<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    public function index()
    {
        $angkatan = Angkatan::withCount('santri')->latest()->get();
        return view('admin.angkatan.index', compact('angkatan'));
    }

    public function create()
    {
        return view('admin.angkatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_angkatan' => ['required', 'string', 'max:10'],
            'nama_angkatan' => ['nullable', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $angkatan = Angkatan::create($validated);

        LogAktivitas::log('Tambah Angkatan', 'angkatan', "Menambahkan angkatan: {$angkatan->tahun_angkatan}");

        return redirect()->route('admin.angkatan.index')
            ->with('success', 'Angkatan berhasil ditambahkan.');
    }

    public function edit(Angkatan $angkatan)
    {
        return view('admin.angkatan.edit', compact('angkatan'));
    }

    public function update(Request $request, Angkatan $angkatan)
    {
        $validated = $request->validate([
            'tahun_angkatan' => ['required', 'string', 'max:10'],
            'nama_angkatan' => ['nullable', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $angkatan->update($validated);

        LogAktivitas::log('Update Angkatan', 'angkatan', "Mengupdate angkatan: {$angkatan->tahun_angkatan}");

        return redirect()->route('admin.angkatan.index')
            ->with('success', 'Angkatan berhasil diupdate.');
    }

    public function destroy(Angkatan $angkatan)
    {
        if ($angkatan->santri()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus angkatan yang masih memiliki santri.');
        }

        LogAktivitas::log('Hapus Angkatan', 'angkatan', "Menghapus angkatan: {$angkatan->tahun_angkatan}");

        $angkatan->delete();

        return redirect()->route('admin.angkatan.index')
            ->with('success', 'Angkatan berhasil dihapus.');
    }
}
