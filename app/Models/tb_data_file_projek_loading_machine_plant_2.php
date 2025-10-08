<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_data_file_projek_loading_machine_plant_2 extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'url_unique_loading_machine',
        'url_unique',
        'file',
        'tanggal_file_diupload',
        'tanggal_file_diubah',
    ];


    protected $guarded = ['id'];
    
    
    public function loadingMachinePlant2()
    {
        return $this->belongsTo(tb_data_loading_machine_plant2::class, 'url_unique_loading_machine', 'url_unique');
    }
}
