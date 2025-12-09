<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'nomor_transaksi',
        'tagihan_id',
        'santri_id',
        'jumlah_bayar',
        'metode_pembayaran',
        'channel_pembayaran',
        'transaction_id',
        'payment_url',
        'status',
        'tanggal_bayar',
        'catatan',
        'gateway_response',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'verified_at' => 'datetime',
        'jumlah_bayar' => 'decimal:2',
        'gateway_response' => 'array',
    ];

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function generateNomorTransaksi(): string
    {
        $prefix = 'TRX';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        return "{$prefix}{$date}{$random}";
    }

    public function scopeBerhasil($query)
    {
        return $query->where('status', 'berhasil');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
