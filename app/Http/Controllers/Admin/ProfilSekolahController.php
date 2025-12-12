<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    public function index()
    {
        $profil = ProfilSekolah::getProfil();

        return view('admin.landing.profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:50'],
            'alamat' => ['required', 'string'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'max:255'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],
            'sejarah' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'foto_gedung' => ['nullable', 'image', 'max:2048'],
            'kepala_sekolah' => ['nullable', 'string', 'max:255'],
            'foto_kepala_sekolah' => ['nullable', 'image', 'max:2048'],
            'kata_sambutan' => ['nullable', 'string'],
            'maps_embed' => ['nullable', 'string'],
            'facebook' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string'],
            'youtube' => ['nullable', 'string'],
            'twitter' => ['nullable', 'string'],
        ]);

        $profil = ProfilSekolah::first() ?? new ProfilSekolah();

        if ($request->hasFile('logo')) {
            if ($profil->logo) {
                Storage::disk('public')->delete($profil->logo);
            }
            $validated['logo'] = $request->file('logo')->store('profil', 'public');
        }

        if ($request->hasFile('foto_gedung')) {
            if ($profil->foto_gedung) {
                Storage::disk('public')->delete($profil->foto_gedung);
            }
            $validated['foto_gedung'] = $request->file('foto_gedung')->store('profil', 'public');
        }

        if ($request->hasFile('foto_kepala_sekolah')) {
            if ($profil->foto_kepala_sekolah) {
                Storage::disk('public')->delete($profil->foto_kepala_sekolah);
            }
            $validated['foto_kepala_sekolah'] = $request->file('foto_kepala_sekolah')->store('profil', 'public');
        }

        $validated['sosial_media'] = [
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'twitter' => $request->twitter,
        ];

        unset($validated['facebook'], $validated['instagram'], $validated['youtube'], $validated['twitter']);

        $profil->fill($validated);
        $profil->save();

        LogAktivitas::log('Update Profil Sekolah', 'profil_sekolah', 'Mengupdate profil sekolah');

        return redirect()->route('admin.landing.profil.index')
            ->with('success', 'Profil sekolah berhasil diupdate.');
    }
}
