<?php

namespace Database\Seeders;

use App\Models\tb_data_mesin_plant_2;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TbDataMesinPlant2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => '43d5ba7e-42bd-496e-bd75-e9c9672a0a4a',
            'nama_mesin' => 'Line 1',
            'kode_mesin' => 'L1'
        ]);

        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => 'd54d340c-17ba-4be8-b90d-1dcee529c284',
            'nama_mesin' => 'Line 2',
            'kode_mesin' => 'L2'
        ]);

        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => 'ffaf761b-2d30-41f6-a023-cb8b351e141b',
            'nama_mesin' => 'Line 3',
            'kode_mesin' => 'L3'
        ]);

        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => '1bd6cf39-8c1f-4b28-8bed-87172d83501e',
            'nama_mesin' => 'Bandsaw + Cutting',
            'kode_mesin' => 'BC'
        ]);

        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => 'feb8472b-3533-44b4-9e79-c7100686fb61',
            'nama_mesin' => 'PAINTING',
            'kode_mesin' => 'PTNG'
        ]);

        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => '876688b7-2f4e-42fd-990c-74d266dc879d',
            'nama_mesin' => 'SHERING BENDING',
            'kode_mesin' => 'SB'
        ]);

        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => 'b8b8bf68-57da-4504-998e-b85d3cd647cd',
            'nama_mesin' => 'Line Cadangan',
            'kode_mesin' => 'LC'
        ]);
    }
}
