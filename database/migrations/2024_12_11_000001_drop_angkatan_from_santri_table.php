<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Remove angkatan_id column from santri table first
        Schema::table('santri', function (Blueprint $table) {
            if (Schema::hasColumn('santri', 'angkatan_id')) {
                $table->dropForeign(['angkatan_id']);
                $table->dropColumn('angkatan_id');
            }
        });

        // Then drop angkatan table
        Schema::dropIfExists('angkatan');
    }

    public function down(): void
    {
        // Recreate angkatan table
        Schema::create('angkatan', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_angkatan');
            $table->string('nama_angkatan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add angkatan_id column back to santri table
        Schema::table('santri', function (Blueprint $table) {
            $table->foreignId('angkatan_id')->nullable()->constrained('angkatan')->onDelete('set null');
        });
    }
};
