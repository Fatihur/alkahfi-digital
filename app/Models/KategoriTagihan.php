<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriTagihan extends Model
{
    use HasFactory;

    protected $table = 'kategori_tagihan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }
}
