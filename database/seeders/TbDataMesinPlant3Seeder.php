<?php

namespace Database\Seeders;

use App\Models\tb_data_mesin_plant_3;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TbDataMesinPlant3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '0ac614ec-3ac5-4ebe-9deb-730dc52d39f1',
            'nama_mesin' => 'Double Culumn',
            'kode_mesin' => 'DB',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => 'a354fe97-c005-4d23-899a-9dd596066d36',
            'nama_mesin' => 'Milling HB',
            'kode_mesin' => 'MHB',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '6ebb09f4-de2d-4b28-81cb-c5e076ef28f7',
            'nama_mesin' => 'Turning 1 Dia 600 x 10.000',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '0d5f283b-ba5b-4b5b-841b-3b4254b90b50',
            'nama_mesin' => 'Turning 2 dia 600 (800) x 3000',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => 'c712e1ef-2bd7-49b9-bab4-3269b7ed2ad3',
            'nama_mesin' => 'Turning 3 dia 600 (800) x 3000',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => 'ec99034f-2ec6-40ba-a425-f291aeaa1332',
            'nama_mesin' => 'Turning',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '160065f8-e88e-4e87-a97e-abf2b365e392',
            'nama_mesin' => 'Turning 4 dia. 1000 (1300) x 1000',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '0b2ae309-1a2f-4c28-8d14-609e51e68e42',
            'nama_mesin' => 'Turning 5  dia. 800 x 2000',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '030a1d38-7839-49e0-9761-6afcd9b8f239',
            'nama_mesin' => 'Turning 6 dia. 500 x 1500',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => 'c93d6837-184c-4587-8a21-9b2bc46c93f8',
            'nama_mesin' => 'Turning 7 dia. 500 x 1500',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '73d461b2-48ea-4ef7-8f3c-80ad6ecd509a',
            'nama_mesin' => 'Turning 8 dia. 500 x 1500',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '2b5bb53c-0c94-41e4-93f3-592dffc10a45',
            'nama_mesin' => 'Miling Manual 1',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '702fd1be-3e9f-4e06-a91c-c98fffadea57',
            'nama_mesin' => 'Milling Manual 2',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '4a930358-04f1-4b4b-b03e-f19e86b2dd47',
            'nama_mesin' => 'Milling Manual 3',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '84203fb5-0250-4807-8aaf-ab888731efe1',
            'nama_mesin' => 'Milling Manual 4',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '8569a1ae-ff74-4516-b6e1-afa41d726c9d',
            'nama_mesin' => 'Surface Grinding',
            'kode_mesin' => '-',
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => '4e5122de-d720-4de5-936e-13fdd8e1d582',
            'nama_mesin' => 'Cylindrical Grinding',
            'kode_mesin' => '-',
        ]);
    }
}
