<?php

namespace Database\Seeders;

use App\Models\tb_data_mesin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TbDataMesinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tb_data_mesin::create([
            'url_unique_mesin' => '71d664eb-22d2-4fb4-a6fe-116d128152db',
            'nama_mesin' => 'Wire Cut P400XL300XT200',
            'kode_mesin' => 'WC'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => '72375cee-ca9b-4a51-904c-9affcee782ba',
            'nama_mesin' => 'CNC Milling Doosan Small X1050-Y550-Z550',
            'kode_mesin' => 'CMDS'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => '313dff50-80f7-4334-a0ca-d6d7d57936e4',
            'nama_mesin' => 'CNC Milling Doosan Big X1300-Y650-Z650',
            'kode_mesin' => 'CMDB'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => '9f10e943-7dd6-4363-af85-36ab0724e7c7',
            'nama_mesin' => 'CNC Milling Mazak X1050-Y550-Z550',
            'kode_mesin' => 'CMM'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => '02003962-a731-4020-b4d1-44810d0bb71a',
            'nama_mesin' => 'CNC Bubut Mazak DIA320x500',
            'kode_mesin' => 'CBM'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => 'e327ed79-33a0-4a96-af65-7f3865148234',
            'nama_mesin' => 'CNC Bubut Doosan DIA360x500',
            'kode_mesin' => 'CBD'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => '6789336d-5a04-42a9-843d-ded8ff38847b',
            'nama_mesin' => 'Surface Grinding 400x800',
            'kode_mesin' => 'SG'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => 'fd63598b-a6ab-4e86-a0f7-60a643a95914',
            'nama_mesin' => 'Cylindrical Grinding Dia300x800',
            'kode_mesin' => 'CG'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => '44dc5fec-e975-4b13-916d-10ccb2654926',
            'nama_mesin' => 'MILING MANUAL 1',
            'kode_mesin' => 'MM1'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => '6ade3a55-a345-46cb-861a-cb9fd7ea5eb3',
            'nama_mesin' => 'MILING MANUAL 2',
            'kode_mesin' => 'MM2'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => 'c92ec403-a01d-45e1-9364-5771ddbcdcd5',
            'nama_mesin' => 'BUBUT MANUAL',
            'kode_mesin' => 'BM'
        ]);
    }
}
