<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tb_data_mesin extends Model
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
        static::deleting(function ($dataMachine) {

            if ($dataMachine->isForceDeleting()) {

                $dataMachine->tb_data_loading_machine_plant_1()->each(function ($dataloadingmachine) {
                    $dataloadingmachine->forceDelete();
                });
            } else {
                $dataMachine->tb_data_loading_machine_plant_1()->each(function ($dataloadingmachine) {
                    $dataloadingmachine->delete();
                });
            }
        });
    }

    public function tb_data_loading_machine_plant_1()
    {
        return $this->hasMany(tb_data_loading_machine_plant1::class, 'url_unique_data_mesin', 'url_unique_mesin');
    }
}
