<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===============================
        // UPDATE TABEL KOLABORASI_IDEAS
        // ===============================
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Ubah kolom deskripsi menjadi text jika terlalu pendek
            $table->text('deskripsi_singkat')->change();

            // Ubah kolom estimasi_waktu jadi varchar(50)
            $table->string('estimasi_waktu', 50)->nullable()->change();

            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('kolaborasi_ideas', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('kolaborasi_ideas', 'subcategory')) {
                $table->string('subcategory')->nullable();
            }
            if (!Schema::hasColumn('kolaborasi_ideas', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable();
            }
            if (!Schema::hasColumn('kolaborasi_ideas', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable();
            }
            if (!Schema::hasColumn('kolaborasi_ideas', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // ===============================
        // UPDATE TABEL KOLABORASI_MEMBERS
        // ===============================
        if (!Schema::hasTable('kolaborasi_members')) {
            Schema::create('kolaborasi_members', function (Blueprint $table) {
                $table->id();
                $table->foreignId('kolaborasi_id')->constrained('kolaborasi_ideas')->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->enum('role', ['leader', 'member'])->default('member');
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // revert perubahan jika rollback
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // bisa dikosongkan atau disesuaikan rollback sesuai kebutuhan
        });

        Schema::dropIfExists('kolaborasi_members');
    }
};
