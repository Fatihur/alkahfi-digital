<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::withCount('santri')->latest()->get();
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => ['required', 'string', 'max:100'],
            'kode_jurusan' => ['nullable', 'string', 'max:20'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $jurusan = Jurusan::create($validated);

        LogAktivitas::log('Tambah Jurusan', 'jurusan', "Menambahkan jurusan: {$jurusan->nama_jurusan}");

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'nama_jurusan' => ['required', 'string', 'max:100'],
            'kode_jurusan' => ['nullable', 'string', 'max:20'],
            'keterangan' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $jurusan->update($validated);

        LogAktivitas::log('Update Jurusan', 'jurusan', "Mengupdate jurusan: {$jurusan->nama_jurusan}");

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil diupdate.');
    }

    public function destroy(Jurusan $jurusan)
    {
        if ($jurusan->santri()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus jurusan yang masih memiliki santri.');
        }

        LogAktivitas::log('Hapus Jurusan', 'jurusan', "Menghapus jurusan: {$jurusan->nama_jurusan}");

        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
