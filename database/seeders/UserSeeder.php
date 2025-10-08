<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'url_unique' => '5ebf05bb-ea54-4838-a706-9589e6291fe8',
            'nama_user' => 'Muhammad Abdillah Asyhar',
            'nik_karyawan' => '12220968',
            'no_telepon' => '081386041278',
            'jabatan' => 'Section Head',
            'plant' => 'Plant 3',
            'image' => 'default.jpg',
            'departemen' => 'Admin',
            'email' => 'mabdillahasyhar758@gmail.com',
            'password' => '$2y$12$s6xiI2OXOnrKTFesQiqIa.M/Xa9xM6FzdeyNPefXyUIYsQnXUJHwG',
            'role' => 1,
            'email_verified_at' => '2024-10-04 12:58:20'
        ]);
    }
}
