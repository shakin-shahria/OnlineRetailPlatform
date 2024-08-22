<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                "name" => "Amir",
                "email" => "amir@gmail.com",  // Corrected key: 'emal' to 'email'
                "password" => Hash::make('12345678'),  // Corrected: 'becrypt' to 'Hash::make'
            ]
        ]);
    }
}