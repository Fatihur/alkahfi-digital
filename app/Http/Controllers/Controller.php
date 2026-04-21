<?php

// =====================================================
// FILE: Controller.php
// DESKRIPSI: Base Controller class untuk semua controller
//            di aplikasi Laravel ini
// LOKASI: app/Http/Controllers/Controller.php
// =====================================================

// Namespace untuk mengelompokkan class Controller
// Sesuai dengan struktur folder app/Http/Controllers
namespace App\Http\Controllers;

/**
 * Class Controller - Base Class untuk Semua Controller
 * 
 * Semua controller lainnya akan extends/mewarisi class ini
 * Contoh: class DashboardController extends Controller
 * 
 * Catatan: Class ini bersifat 'abstract' artinya tidak bisa
 * diinstansiasi langsung, hanya bisa diwarisi
 */
abstract class Controller
{
    // 
    // Base controller kosong, biasanya digunakan untuk:
    // 1. Menyimpan method yang digunakan semua controller
    // 2. Menyimpan property umum yang dibutuhkan semua controller
    // 3. Sebagai parent class untuk inheritance
    //
    // Contoh penggunaan method umum:
    // protected function responseJson($data, $status = 200) {
    //     return response()->json($data, $status);
    // }
    //
    // Contoh property umum:
    // protected $perPage = 10; // Default item per halaman untuk pagination
}
