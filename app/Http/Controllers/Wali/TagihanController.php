<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $santriIds = $user->waliSantri()->pluck('santri_id');

        $query = Tagihan::whereIn('santri_id', $santriIds)
            ->with('santri');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }

        $tagihan = $query->latest()->paginate(10);
        $santriList = $user->waliSantri()->with('santri')->get()->pluck('santri');

        return view('wali.tagihan.index', compact('tagihan', 'santriList'));
    }

    public function show(Tagihan $tagihan)
    {
        $this->authorizeTagihan($tagihan);

        $tagihan->load(['santri', 'pembayaran']);
        return view('wali.tagihan.show', compact('tagihan'));
    }

    protected function authorizeTagihan(Tagihan $tagihan)
    {
        $user = auth()->user();
        $santriIds = $user->waliSantri()->pluck('santri_id')->toArray();

        if (!in_array($tagihan->santri_id, $santriIds)) {
            abort(403, 'Anda tidak memiliki akses ke tagihan ini.');
        }
    }
}
