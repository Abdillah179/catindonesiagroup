<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_data_loading_machine_plant3 extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'url_unique_data_mesin',
        'url_unique',
        'plant',
        'nama_mesin',
        'project',
        'customer',
        'no_spk',
        'qty',
        'estimasi_jam',
        'actual_jam',
        'start',
        'target_finish',
        'priority',
        'on_proses',
        'operator',
        'keterangan',
        'status_done',
        'tanggal_input',
        'user_pengupdated_data_loading_mesin',
        'departemen_user_pengupdated_data_loading_mesin',
        'plant_user_pengupdated_data_loading_mesin',
        'tanggal_updated_data_loading_mesin',
        'jam_updated_data_loading_mesin',
        'user_pengupdated_status_done_loading_mesin',
        'departemen_user_pengupdated_status_done_loading_mesin',
        'plant_user_pengupdated_status_done_loading_mesin',
        'tanggal_updated_status_done_loading_mesin',
        'jam_updated_status_done_loading_mesin',
    ];


    protected $guarded = ['id'];


    public function tb_data_mesin_plants_3()
    {
        return $this->belongsTo(tb_data_mesin_plant_3::class, 'url_unique_data_mesin', 'url_unique_mesin');
    }
    
    public function fileProjekLoadingMachinePlant3()
    {
        return $this->hasMany(tb_data_file_projek_loading_machine_plant_3::class, 'url_unique_loading_machine', 'url_unique');
    }
}
