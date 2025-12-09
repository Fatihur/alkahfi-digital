<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->foreignId('kategori_tagihan_id')->nullable()->constrained('kategori_tagihan')->onDelete('set null');
            $table->string('nama_tagihan', 150);
            $table->string('periode', 20)->nullable();
            $table->integer('bulan')->nullable();
            $table->integer('tahun');
            $table->decimal('nominal', 15, 2);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('denda', 15, 2)->default(0);
            $table->decimal('total_bayar', 15, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['belum_bayar', 'pending', 'lunas', 'jatuh_tempo'])->default('belum_bayar');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
