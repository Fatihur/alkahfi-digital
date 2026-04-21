<?php

// =====================================================
// FILE: LoginController.php
// DESKRIPSI: Controller untuk autentikasi user (login/logout)
// LOKASI: app/Http/Controllers/Auth/LoginController.php
// ROUTES: 
//   - GET  /login          -> showLoginForm()
//   - POST /login          -> login()
//   - POST /logout         -> logout()
// =====================================================

namespace App\Http\Controllers\Auth;

// Import class yang dibutuhkan
use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Facade untuk autentikasi Laravel

/**
 * Class LoginController
 * 
 * Menangani proses login, logout, dan redirect berdasarkan role
 * Menggunakan Laravel Auth Facade untuk autentikasi
 */
class LoginController extends Controller
{
    /**
     * Method showLoginForm() - Menampilkan form login
     * 
     * URL: GET /login
     * Return: View form login
     * 
     * Middleware 'guest' biasanya diterapkan di route
     * sehingga user yang sudah login tidak bisa akses halaman ini
     */
    public function showLoginForm()
    {
        // Return view auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Method login() - Proses autentikasi user
     * 
     * URL: POST /login
     * Parameter: email, password, remember (boolean)
     * Return: Redirect ke dashboard sesuai role atau kembali ke login dengan error
     * 
     * Alur proses:
     * 1. Validasi input
     * 2. Cek kredensial dengan Auth::attempt()
     * 3. Cek status akun aktif/nonaktif
     * 4. Regenerate session untuk keamanan
     * 5. Catat log aktivitas
     * 6. Redirect berdasarkan role
     */
    public function login(Request $request)
    {
        // =====================================================
        // BAGIAN 1: VALIDASI INPUT
        // =====================================================
        
        // Validasi email dan password wajib diisi
        // email: format harus valid email
        // password: wajib diisi (string)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // =====================================================
        // BAGIAN 2: CEK KREDENSIAL
        // =====================================================
        
        // Auth::attempt() = Cek email dan password di database
        // Parameter 1: Array kredensial (email, password)
        // Parameter 2: Boolean 'remember me' (buat cookie remember)
        // Return: true jika berhasil, false jika gagal
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // Regenerate session ID untuk mencegah session fixation attack
            // Session lama dihapus, session baru dibuat
            $request->session()->regenerate();

            // =====================================================
            // BAGIAN 3: CEK STATUS AKUN
            // =====================================================
            
            // Cek apakah akun user masih aktif
            // is_active = false berarti akun dinonaktifkan oleh admin
            if (!auth()->user()->is_active) {
                // Logout user yang dinonaktifkan
                Auth::logout();
                
                // Kembali ke form dengan error message
                // withErrors(): Kirim error ke view (bisa diakses dengan $errors)
                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan.',
                ]);
            }

            // =====================================================
            // BAGIAN 4: CATAT LOG AKTIVITAS
            // =====================================================
            
            // Mencatat login untuk audit trail
            LogAktivitas::log('Login', 'auth', 'User berhasil login');

            // =====================================================
            // BAGIAN 5: REDIRECT BERDASARKAN ROLE
            // =====================================================
            
            // Panggil method untuk redirect sesuai role user
            return $this->redirectBasedOnRole();
        }

        // =====================================================
        // BAGIAN 6: LOGIN GAGAL
        // =====================================================
        
        // Jika Auth::attempt() return false (password/email salah)
        // Kembali ke form dengan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])
        // onlyInput('email'): Pertahankan input email di form
        // Password tidak disimpan untuk keamanan
        ->onlyInput('email');
    }

    /**
     * Method logout() - Proses logout user
     * 
     * URL: POST /logout
     * Return: Redirect ke halaman login
     * 
     * Membersihkan session dan invalidate token
     */
    public function logout(Request $request)
    {
        // Catat aktivitas logout sebelum logout
        LogAktivitas::log('Logout', 'auth', 'User logout');

        // Logout user (hapus dari session)
        Auth::logout();
        
        // Invalidate session (hapus semua data session)
        $request->session()->invalidate();
        
        // Regenerate CSRF token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login');
    }

    /**
     * Method redirectBasedOnRole() - Redirect berdasarkan role user
     * 
     * Protected method (hanya bisa dipanggil dalam class ini)
     * Menggunakan PHP 8 match expression untuk switch case
     * 
     * Return: RedirectResponse ke dashboard sesuai role
     * 
     * Role yang tersedia:
     * - admin        -> Dashboard Admin
     * - bendahara    -> Dashboard Bendahara
     * - wali_santri  -> Dashboard Wali Santri
     * - default      -> Login (fallback)
     */
    protected function redirectBasedOnRole()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Match expression (PHP 8+): Switch case yang lebih clean
        // Cek $user->role dan return redirect yang sesuai
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),        // Admin ke dashboard admin
            'bendahara' => redirect()->route('bendahara.dashboard'), // Bendahara ke dashboard bendahara
            'wali_santri' => redirect()->route('wali.dashboard'),    // Wali ke dashboard wali
            default => redirect()->route('login'),                   // Fallback ke login
        };
    }
}
