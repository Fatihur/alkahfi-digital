<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal_pelaksanaan',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'gambar',
        'status',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
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

    public function scopeAkanDatang($query)
    {
        return $query->where('status', 'akan_datang');
    }
}
