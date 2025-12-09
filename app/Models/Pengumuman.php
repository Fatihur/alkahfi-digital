<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'prioritas',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_published' => 'boolean',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeAktif($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('tanggal_mulai')
              ->orWhere('tanggal_mulai', '<=', now());
        })->where(function ($q) {
            $q->whereNull('tanggal_selesai')
              ->orWhere('tanggal_selesai', '>=', now());
        });
    }
}
