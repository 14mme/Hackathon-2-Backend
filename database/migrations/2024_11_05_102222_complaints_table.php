<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('tracking_id', 10)->unique()->notNull(); // Unique tracking ID
            $table->enum('classification', ['Pengaduan','Aspirasi','Pengaduan Informasi']); // Classification
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('judul_laporan');
            $table->string('deskripsi_laporan');
            $table->date('date')->notNull(); // Date of complaint
            $table->string('instansi_tujuan', 100)->notNull(); // Target agency
            $table->enum('status', ['Diterima', 'Proses', 'Ditolak'])->default('Proses'); // Status of complaint
            $table->string('kategori_laporan', 100)->notNull(); // Report category
            $table->string('bukti')->NULL;
            $table->timestamps(); // Created and updated timestamps
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaints');
    }

};
