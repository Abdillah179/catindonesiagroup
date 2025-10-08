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
        Schema::create('tb_data_mesin_plant_2s', function (Blueprint $table) {
            $table->id();
            $table->string('url_unique_mesin')->unique();
            $table->string('nama_mesin')->unique();
            $table->string('kode_mesin')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_data_mesin_plant_2s');
    }
};
