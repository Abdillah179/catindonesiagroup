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
        Schema::create('tb_data_file_projek_loading_machine_plant_3s', function (Blueprint $table) {
            $table->id();
            $table->string('url_unique_loading_machine')->nullable();
            $table->string('url_unique')->unique();
            $table->text('file')->nullable();
            $table->string('tanggal_file_diupload')->nullable();
            $table->string('tanggal_file_diubah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_data_file_projek_loading_machine_plant_3s');
    }
};
