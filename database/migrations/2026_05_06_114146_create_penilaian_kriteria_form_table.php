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
        Schema::create('penilaian_kriteria_form', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPenilaianForm');
            $table->unsignedBigInteger('idKriteriaKinerja');
            $table->double('nilai');
            $table->timestamps();

            $table->foreign('idPenilaianForm')->references('id')->on('penilaian_kinerja_form')->onDelete('cascade');
            $table->foreign('idKriteriaKinerja')->references('id')->on('kriteria_kinerja')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kriteria_form');
    }
};
