<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel utama untuk ide kolaborasi
        Schema::create('kolaborasi_ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('restrict')->onUpdate('cascade');
            $table->string('judul', 255);
            $table->string('deskripsi_singkat', 200);
            $table->text('latar_belakang')->nullable();
            $table->text('solusi')->nullable();
            $table->enum('estimasi_waktu', ['1-3', '3-6', '6-12', '12+'])->nullable();
            $table->enum('kompleksitas', ['low', 'medium', 'high'])->nullable();
            $table->text('dampak')->nullable();
            $table->string('dokumen_path', 500)->nullable();
            $table->enum('status', ['draft','submitted','under_review','approved','rejected','in_progress','completed'])->default('draft')->index('ideas_status_idx');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id','status'], 'ideas_user_status_idx');
            $table->index(['category_id','status'], 'ideas_cat_status_idx');
            $table->index(['created_at','status'], 'ideas_created_status_idx');
        });

        // Tabel untuk keahlian yang dibutuhkan
        Schema::create('kolaborasi_keahlian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_idea_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('keahlian', 100);
            $table->timestamps();

            $table->unique(['kolaborasi_idea_id','keahlian'], 'keahlian_unique');
            $table->index('keahlian', 'keahlian_idx');
        });

        // Tabel untuk partner yang diinginkan
        Schema::create('kolaborasi_partner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_idea_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('partner',['pemerintah','akademisi','umkm','komunitas','swasta','lainnya']);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->unique(['kolaborasi_idea_id','partner'], 'partner_unique');
            $table->index('partner', 'partner_idx');
        });

        // Tabel untuk proyek kolaborasi
        Schema::create('kolaborasi_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_idea_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->unique();
            $table->string('kode_proyek',50)->unique();
            $table->string('nama_proyek',255);
            $table->text('deskripsi');
            $table->text('tujuan')->nullable();
            $table->text('ruang_lingkup')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai_rencana')->nullable();
            $table->date('tanggal_selesai_aktual')->nullable();
            $table->enum('status',['planning','in_progress','on_hold','completed','cancelled'])->default('planning')->index('projects_status_idx');
            $table->integer('progress')->default(0)->unsigned();
            $table->decimal('budget',15,2)->nullable()->default(0);
            $table->string('color',7)->default('#3b82f6');
            $table->boolean('is_public')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status','tanggal_mulai'], 'projects_status_tgl_idx');
            $table->index('kode_proyek','projects_kode_idx');
        });

        // Tabel untuk anggota proyek
        Schema::create('kolaborasi_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_project_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('role',['leader','member','reviewer','stakeholder'])->default('member');
            $table->json('permissions')->nullable();
            $table->date('tanggal_bergabung')->useCurrent();
            $table->date('tanggal_keluar')->nullable();
            $table->text('alasan_keluar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['kolaborasi_project_id','user_id'],'anggota_unique');
            $table->index(['kolaborasi_project_id','role'],'anggota_role_idx');
        });

        // Tabel untuk tugas
        Schema::create('kolaborasi_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_project_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('kode_tugas',50)->nullable();
            $table->string('judul',255);
            $table->text('deskripsi')->nullable();
            $table->text('acceptance_criteria')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('kolaborasi_tugas')->onDelete('cascade');
            $table->foreignId('assignee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status',['todo','in_progress','review','revision','completed','cancelled'])->default('todo')->index('tugas_status_idx');
            $table->enum('prioritas',['low','medium','high','urgent'])->default('medium');
            $table->integer('estimasi_jam')->nullable()->unsigned();
            $table->integer('actual_jam')->nullable()->unsigned();
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->date('completed_at')->nullable();
            $table->integer('progress')->default(0)->unsigned();
            $table->json('dependencies')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['kolaborasi_project_id','status'],'tugas_proj_status_idx');
            $table->index(['assignee_id','status'],'tugas_assignee_status_idx');
        });

        // Tabel untuk dokumentasi
        Schema::create('kolaborasi_dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_project_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul',255);
            $table->text('konten')->nullable();
            $table->string('file_path',500)->nullable();
            $table->string('file_name',255)->nullable();
            $table->integer('file_size')->nullable()->unsigned();
            $table->enum('tipe',['meeting_note','documentation','decision','requirement','design','report','other'])->default('documentation');
            $table->enum('visibility',['public','team','private'])->default('team');
            $table->integer('versi')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('kolaborasi_dokumentasi')->onDelete('cascade');
            $table->boolean('is_current')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['kolaborasi_project_id','tipe'],'dokumentasi_proj_tipe_idx');
            $table->index(['user_id','created_at'],'dokumentasi_user_created_idx');
        });

        // Tabel untuk aktivitas
        Schema::create('kolaborasi_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_project_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('aksi',100);
            $table->text('deskripsi');
            $table->string('target_type',100);
            $table->unsignedBigInteger('target_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address',45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('logged_at')->useCurrent();

            $table->index(['kolaborasi_project_id','target_type','target_id'],'aktivitas_proj_target_idx');
            $table->index(['user_id','logged_at'],'aktivitas_user_idx');
            $table->index('logged_at','aktivitas_logged_idx');
        });

        // Tabel untuk review
        Schema::create('kolaborasi_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolaborasi_project_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul',255);
            $table->text('komentar');
            $table->enum('tipe',['progress_review','task_review','document_review','design_review','code_review','final_review'])->default('progress_review');
            $table->enum('status',['pending','approved','revisions_required','cancelled'])->default('pending');
            $table->integer('rating')->nullable()->unsigned();
            $table->integer('versi')->default(1);
            $table->string('target_type',100)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('kolaborasi_reviews')->onDelete('cascade');
            $table->boolean('is_final')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['kolaborasi_project_id','tipe'],'reviews_proj_tipe_idx');
            $table->index(['target_type','target_id'],'reviews_target_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kolaborasi_reviews');
        Schema::dropIfExists('kolaborasi_aktivitas');
        Schema::dropIfExists('kolaborasi_dokumentasi');
        Schema::dropIfExists('kolaborasi_tugas');
        Schema::dropIfExists('kolaborasi_anggota');
        Schema::dropIfExists('kolaborasi_projects');
        Schema::dropIfExists('kolaborasi_partner');
        Schema::dropIfExists('kolaborasi_keahlian');
        Schema::dropIfExists('kolaborasi_ideas');
    }
};
