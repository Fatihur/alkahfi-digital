<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    use HasFactory;

    protected $table = 'profil_sekolah';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat',
        'telepon',
        'email',
        'website',
        'visi',
        'misi',
        'sejarah',
        'logo',
        'foto_gedung',
        'kepala_sekolah',
        'foto_kepala_sekolah',
        'kata_sambutan',
        'maps_embed',
        'sosial_media',
    ];

    protected $casts = [
        'sosial_media' => 'array',
    ];

    public static function getProfil()
    {
        return self::first() ?? new self();
    }
}
