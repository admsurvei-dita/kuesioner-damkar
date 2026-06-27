<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Modifikasi Tabel Users Bawaan Breeze
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status_kepegawaian')) {
                $table->string('status_kepegawaian')->nullable(); // PNS, PPPK, TKK/Honorer
                $table->enum('kelompok_responden', ['A', 'B', 'C', 'D', 'E'])->nullable();
                $table->string('unit_kerja')->nullable(); // Dropdown 10 Pos Sektor
                $table->enum('role', ['admin', 'responden'])->default('responden');
                $table->boolean('is_completed')->default(false);
            }
        });

        // 2. Tabel Pertanyaan (Dukungan Matriks & Custom)
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('klaster'); // Penanggulangan Kebakaran, Penyelamatan, Validasi Anggaran, dll
            $table->string('sub_klaster')->nullable();
            $table->text('text_pertanyaan');
            $table->json('target_kelompok'); // e.g. ["A", "E", "C"]
            $table->enum('type', ['matrix', 'normal', 'custom'])->default('normal');
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Untuk melacak siapa yang membuat custom hazard
            $table->timestamps();
        });

        // 3. Tabel Opsi Jawaban Global & Spesifik
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->nullable()->constrained('questions')->onDelete('cascade'); // Nullable untuk opsi parameter global (P, E, C)
            $table->text('text_pilihan');
            $table->enum('parameter_type', ['C', 'E', 'P', 'N/A']);
            $table->float('score_value')->default(0.0);
            $table->text('deskripsi_kriteria')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Jawaban Responden Terintegrasi
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');

            // Untuk jenis normal (Single-Choice Validasi Anggaran / Danru)
            $table->foreignId('option_id')->nullable()->constrained('options')->onDelete('cascade');

            // Untuk jenis matrix / custom (Fine & Kinney parameters)
            $table->float('score_e')->nullable();
            $table->float('score_p')->nullable();
            $table->float('score_c')->nullable();

            $table->text('text_jawaban_manual')->nullable(); // Catatan kualitatif (Anjab-ABK evidence)
            $table->timestamps();
        });

        // 5. Tabel Riwayat Kesehatan & Cedera (Dinamis Multi-Entry)
        Schema::create('responder_health_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kategori_dampak'); // Kecelakaan Kerja, Penyakit Kerja, Cedera Ringan
            $table->text('deskripsi_kronologi');
            $table->year('tahun_kejadian');
            $table->string('dampak_tugas'); // Sembuh Total, Penurunan Fisik, Trauma
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responder_health_histories');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('options');
        Schema::dropIfExists('questions');
    }
};