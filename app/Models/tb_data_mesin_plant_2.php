<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_data_mesin_plant_2 extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'url_unique_mesin',
        'nama_mesin',
        'kode_mesin'
    ];


    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($dataMachinePlant2) {

            if ($dataMachinePlant2->isForceDeleting()) {

                $dataMachinePlant2->tb_data_loading_machine_plant_2()->each(function ($dataloadingmachine) {
                    $dataloadingmachine->forceDelete();
                });
            } else {
                $dataMachinePlant2->tb_data_loading_machine_plant_2()->each(function ($dataloadingmachine) {
                    $dataloadingmachine->delete();
                });
            }
        });
    }

    public function tb_data_loading_machine_plant_2()
    {
        return $this->hasMany(tb_data_loading_machine_plant2::class, 'url_unique_data_mesin', 'url_unique_mesin');
    }
}
