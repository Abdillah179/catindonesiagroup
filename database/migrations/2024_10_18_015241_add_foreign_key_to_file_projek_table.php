<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_data_file_projek_loading_machine_plant_1s', function (Blueprint $table) {
            // Tambahkan foreign key
            $table->foreign('url_unique_loading_machine', 'fk_file_projek_loading_machine')
                ->references('url_unique')
                ->on('tb_data_loading_machine_plant1s')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_data_file_projek_loading_machine_plant_1s', function (Blueprint $table) {
            $table->dropForeign('fk_file_projek_loading_machine');
        });
    }
};
