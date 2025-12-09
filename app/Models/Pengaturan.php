<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'kunci',
        'nilai',
        'grup',
        'deskripsi',
    ];

    public static function get(string $kunci, $default = null)
    {
        return Cache::remember("pengaturan.{$kunci}", 3600, function () use ($kunci, $default) {
            $pengaturan = self::where('kunci', $kunci)->first();
            return $pengaturan ? $pengaturan->nilai : $default;
        });
    }

    public static function set(string $kunci, $nilai, string $grup = 'umum'): void
    {
        self::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai, 'grup' => $grup]
        );
        Cache::forget("pengaturan.{$kunci}");
    }
}
