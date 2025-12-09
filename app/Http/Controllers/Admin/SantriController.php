<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with(['kelas', 'angkatan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $santri = $query->latest()->paginate(10);
        $kelasList = Kelas::where('is_active', true)->get();

        return view('admin.santri.index', compact('santri', 'kelasList'));
    }

    public function create()
    {
        $kelasList = Kelas::where('is_active', true)->get();
        $angkatanList = Angkatan::where('is_active', true)->get();
        $waliList = User::where('role', 'wali_santri')->where('is_active', true)->get();

        return view('admin.santri.create', compact('kelasList', 'angkatanList', 'waliList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:20', 'unique:santri'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'angkatan_id' => ['required', 'exists:angkatan,id'],
            'tanggal_masuk' => ['nullable', 'date'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:aktif,nonaktif,lulus,pindah'],
            'wali_id' => ['nullable', 'exists:users,id'],
            'hubungan' => ['nullable', 'in:ayah,ibu,wali'],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('santri', 'public');
        }

        unset($validated['wali_id'], $validated['hubungan']);
        $santri = Santri::create($validated);

        if ($request->filled('wali_id')) {
            WaliSantri::create([
                'user_id' => $request->wali_id,
                'santri_id' => $santri->id,
                'hubungan' => $request->hubungan ?? 'wali',
            ]);
        }

        LogAktivitas::log('Tambah Santri', 'santri', "Menambahkan santri: {$santri->nama_lengkap}", null, $santri->toArray());

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function show(Santri $santri)
    {
        $santri->load(['kelas', 'angkatan', 'wali', 'tagihan', 'pembayaran']);
        return view('admin.santri.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        $kelasList = Kelas::where('is_active', true)->get();
        $angkatanList = Angkatan::where('is_active', true)->get();
        $waliList = User::where('role', 'wali_santri')->where('is_active', true)->get();
        $santri->load('wali');

        return view('admin.santri.edit', compact('santri', 'kelasList', 'angkatanList', 'waliList'));
    }

    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:20', 'unique:santri,nis,' . $santri->id],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'angkatan_id' => ['required', 'exists:angkatan,id'],
            'tanggal_masuk' => ['nullable', 'date'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:aktif,nonaktif,lulus,pindah'],
        ]);

        $oldData = $santri->toArray();

        if ($request->hasFile('foto')) {
            if ($santri->foto) {
                Storage::disk('public')->delete($santri->foto);
            }
            $validated['foto'] = $request->file('foto')->store('santri', 'public');
        }

        $santri->update($validated);

        LogAktivitas::log('Update Santri', 'santri', "Mengupdate santri: {$santri->nama_lengkap}", $oldData, $santri->fresh()->toArray());

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil diupdate.');
    }

    public function destroy(Santri $santri)
    {
        LogAktivitas::log('Hapus Santri', 'santri', "Menghapus santri: {$santri->nama_lengkap}", $santri->toArray());

        if ($santri->foto) {
            Storage::disk('public')->delete($santri->foto);
        }

        $santri->delete();

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil dihapus.');
    }
}
