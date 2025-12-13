<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'santri_id',
        'nama_tagihan',
        'periode',
        'bulan',
        'tahun',
        'nominal',
        'diskon',
        'denda',
        'total_bayar',
        'tanggal_jatuh_tempo',
        'status',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'nominal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'denda' => 'decimal:2',
        'total_bayar' => 'decimal:2',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function hitungTotal(): float
    {
        return $this->nominal - $this->diskon + $this->denda;
    }

    public function scopeBelumBayar($query)
    {
        return $query->where('status', 'belum_bayar');
    }

    public function scopeLunas($query)
    {
        return $query->where('status', 'lunas');
    }

    public function scopeJatuhTempo($query)
    {
        return $query->where('status', 'jatuh_tempo');
    }
}
