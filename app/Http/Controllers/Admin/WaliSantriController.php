<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WaliSantriController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'wali_santri')
            ->with(['waliSantri.santri']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $waliSantri = $query->latest()->get();

        return view('admin.wali-santri.index', compact('waliSantri'));
    }

    public function create()
    {
        $santriTanpaWali = Santri::whereDoesntHave('waliSantri')
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();
        
        $semuaSantri = Santri::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.wali-santri.create', compact('santriTanpaWali', 'semuaSantri'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8'],
            'generate_password' => ['nullable', 'boolean'],
            'santri_ids' => ['required', 'array', 'min:1'],
            'santri_ids.*' => ['exists:santri,id'],
            'hubungan' => ['required', 'array'],
            'hubungan.*' => ['required', Rule::in(['ayah', 'ibu', 'wali'])],
        ]);

        $generatedPassword = null;
        
        if ($request->boolean('generate_password') || empty($validated['password'])) {
            $generatedPassword = Str::random(8);
            $validated['password'] = Hash::make($generatedPassword);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] ?? null,
                'password' => $validated['password'],
                'role' => 'wali_santri',
                'is_active' => true,
            ]);

            foreach ($validated['santri_ids'] as $index => $santriId) {
                WaliSantri::create([
                    'user_id' => $user->id,
                    'santri_id' => $santriId,
                    'hubungan' => $validated['hubungan'][$index] ?? 'wali',
                ]);
            }

            LogAktivitas::log('Tambah Wali Santri', 'wali_santri', "Menambahkan wali santri: {$user->name}", null, $user->toArray());

            DB::commit();

            $message = 'Wali santri berhasil ditambahkan.';
            if ($generatedPassword) {
                $message .= " Password: {$generatedPassword}";
            }

            return redirect()->route('admin.wali-santri.show', $user)
                ->with('success', $message)
                ->with('generated_password', $generatedPassword);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan wali santri: ' . $e->getMessage())->withInput();
        }
    }

    public function show(User $wali_santri)
    {
        $wali_santri->load(['waliSantri.santri.kelas']);
        
        return view('admin.wali-santri.show', compact('wali_santri'));
    }

    public function edit(User $wali_santri)
    {
        $wali_santri->load('waliSantri');
        
        $semuaSantri = Santri::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $santriTerpilih = $wali_santri->waliSantri->pluck('santri_id')->toArray();
        $hubunganSantri = $wali_santri->waliSantri->pluck('hubungan', 'santri_id')->toArray();

        return view('admin.wali-santri.edit', compact('wali_santri', 'semuaSantri', 'santriTerpilih', 'hubunganSantri'));
    }

    public function update(Request $request, User $wali_santri)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($wali_santri->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8'],
            'is_active' => ['nullable', 'boolean'],
            'santri_ids' => ['required', 'array', 'min:1'],
            'santri_ids.*' => ['exists:santri,id'],
            'hubungan' => ['required', 'array'],
            'hubungan.*' => ['required', Rule::in(['ayah', 'ibu', 'wali'])],
        ]);

        $oldData = $wali_santri->toArray();

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $wali_santri->update($userData);

            // Sync santri relationships
            WaliSantri::where('user_id', $wali_santri->id)->delete();
            
            foreach ($validated['santri_ids'] as $index => $santriId) {
                WaliSantri::create([
                    'user_id' => $wali_santri->id,
                    'santri_id' => $santriId,
                    'hubungan' => $validated['hubungan'][$index] ?? 'wali',
                ]);
            }

            LogAktivitas::log('Update Wali Santri', 'wali_santri', "Mengupdate wali santri: {$wali_santri->name}", $oldData, $wali_santri->fresh()->toArray());

            DB::commit();

            return redirect()->route('admin.wali-santri.index')
                ->with('success', 'Wali santri berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate wali santri: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(User $wali_santri)
    {
        LogAktivitas::log('Hapus Wali Santri', 'wali_santri', "Menghapus wali santri: {$wali_santri->name}", $wali_santri->toArray());

        $wali_santri->delete();

        return redirect()->route('admin.wali-santri.index')
            ->with('success', 'Wali santri berhasil dihapus.');
    }

    /**
     * Generate akun otomatis untuk santri yang belum punya wali
     */
    public function generateAkun(Request $request)
    {
        $validated = $request->validate([
            'santri_ids' => ['required', 'array', 'min:1'],
            'santri_ids.*' => ['exists:santri,id'],
            'hubungan_default' => ['required', Rule::in(['ayah', 'ibu', 'wali'])],
        ]);

        $results = [];
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($validated['santri_ids'] as $santriId) {
                $santri = Santri::find($santriId);
                
                // Generate email dari nama santri
                $baseEmail = Str::slug($santri->nama_lengkap, '.') . '@wali.pesantren.id';
                $email = $baseEmail;
                $counter = 1;
                
                while (User::where('email', $email)->exists()) {
                    $email = Str::slug($santri->nama_lengkap, '.') . $counter . '@wali.pesantren.id';
                    $counter++;
                }

                // Generate password
                $password = Str::random(8);

                // Buat user
                $user = User::create([
                    'name' => 'Wali ' . $santri->nama_lengkap,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'wali_santri',
                    'is_active' => true,
                ]);

                // Hubungkan dengan santri
                WaliSantri::create([
                    'user_id' => $user->id,
                    'santri_id' => $santriId,
                    'hubungan' => $validated['hubungan_default'],
                ]);

                $results[] = [
                    'santri' => $santri->nama_lengkap,
                    'email' => $email,
                    'password' => $password,
                ];

                LogAktivitas::log('Generate Akun Wali', 'wali_santri', "Generate akun wali untuk santri: {$santri->nama_lengkap}", null, $user->toArray());
            }

            DB::commit();

            return redirect()->route('admin.wali-santri.index')
                ->with('success', 'Berhasil generate ' . count($results) . ' akun wali santri.')
                ->with('generated_accounts', $results);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal generate akun: ' . $e->getMessage());
        }
    }

    /**
     * Form untuk generate akun massal
     */
    public function showGenerateForm()
    {
        $santriTanpaWali = Santri::whereDoesntHave('waliSantri')
            ->where('status', 'aktif')
            ->with(['kelas'])
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.wali-santri.generate', compact('santriTanpaWali'));
    }

    /**
     * Reset password wali santri
     */
    public function resetPassword(User $wali_santri)
    {
        $newPassword = Str::random(8);
        
        $wali_santri->update([
            'password' => Hash::make($newPassword),
        ]);

        LogAktivitas::log('Reset Password Wali', 'wali_santri', "Reset password wali santri: {$wali_santri->name}");

        return back()
            ->with('success', "Password berhasil direset. Password baru: {$newPassword}")
            ->with('new_password', $newPassword);
    }
}
