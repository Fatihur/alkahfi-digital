<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('wali.notifikasi.index', compact('notifikasi'));
    }

    public function show(Notifikasi $notifikasi)
    {
        // Pastikan notifikasi milik user yang login
        if ($notifikasi->user_id !== auth()->id()) {
            abort(403);
        }

        // Tandai sebagai sudah dibaca
        $notifikasi->markAsRead();

        // Redirect ke link jika ada dan valid
        if ($notifikasi->link) {
            // Cek apakah link adalah URL relatif atau absolute
            $link = $notifikasi->link;
            
            // Jika link relatif, pastikan dimulai dengan /
            if (!str_starts_with($link, 'http') && !str_starts_with($link, '/')) {
                $link = '/' . $link;
            }
            
            return redirect($link);
        }

        // Jika tidak ada link, redirect ke halaman tagihan berdasarkan tipe
        if ($notifikasi->tipe === 'tagihan') {
            return redirect()->route('wali.tagihan.index');
        } elseif ($notifikasi->tipe === 'pembayaran') {
            return redirect()->route('wali.pembayaran.index');
        }

        return redirect()->route('wali.notifikasi.index');
    }

    public function markAllAsRead()
    {
        Notifikasi::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    public function getUnreadCount()
    {
        $count = Notifikasi::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getLatest()
    {
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $unreadCount = Notifikasi::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifikasi' => $notifikasi,
            'unread_count' => $unreadCount,
        ]);
    }
}
