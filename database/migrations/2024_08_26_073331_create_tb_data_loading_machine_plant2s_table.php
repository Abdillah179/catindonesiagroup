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
        Schema::create('tb_data_loading_machine_plant2s', function (Blueprint $table) {
            $table->id();
            $table->string('url_unique_data_mesin');
            $table->string('url_unique')->unique();
            $table->string('plant');
            $table->string('nama_mesin');
            $table->string('project');
            $table->string('customer');
            $table->string('no_spk');
            $table->string('qty');
            $table->string('estimasi_jam');
            $table->string('actual_jam');
            $table->string('start');
            $table->string('target_finish');
            $table->string('priority');
            $table->string('on_proses');
            $table->string('operator');
            $table->string('keterangan');
            $table->enum('status_done', ['Not Done', 'Done']);
            $table->date('tanggal_input');
            $table->string('user_pengupdated_data_loading_mesin')->nullable();
            $table->string('departemen_user_pengupdated_data_loading_mesin')->nullable();
            $table->string('plant_user_pengupdated_data_loading_mesin')->nullable();
            $table->string('tanggal_updated_data_loading_mesin')->nullable();
            $table->string('jam_updated_data_loading_mesin')->nullable();
            $table->string('user_pengupdated_status_done_loading_mesin')->nullable();
            $table->string('departemen_user_pengupdated_status_done_loading_mesin')->nullable();
            $table->string('plant_user_pengupdated_status_done_loading_mesin')->nullable();
            $table->string('tanggal_updated_status_done_loading_mesin')->nullable();
            $table->string('jam_updated_status_done_loading_mesin')->nullable();
            $table->timestamps();

            $table->foreign('url_unique_data_mesin')
                ->references('url_unique_mesin')
                ->on('tb_data_mesin_plant_2s');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_data_loading_machine_plant2s');
    }
};
