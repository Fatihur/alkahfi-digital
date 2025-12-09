<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('urutan')->paginate(10)->withQueryString();

        return view('admin.landing.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.landing.slider.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['required', 'image', 'max:2048'],
            'link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['gambar'] = $request->file('gambar')->store('slider', 'public');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $slider = Slider::create($validated);

        LogAktivitas::log('Tambah Slider', 'slider', "Menambahkan slider: {$slider->judul}");

        return redirect()->route('admin.landing.slider.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.landing.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'judul' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($slider->gambar);
            $validated['gambar'] = $request->file('gambar')->store('slider', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $slider->update($validated);

        LogAktivitas::log('Update Slider', 'slider', "Mengupdate slider: {$slider->judul}");

        return redirect()->route('admin.landing.slider.index')
            ->with('success', 'Slider berhasil diupdate.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->gambar);

        LogAktivitas::log('Hapus Slider', 'slider', "Menghapus slider: {$slider->judul}");

        $slider->delete();

        return redirect()->route('admin.landing.slider.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
