<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

use DB;

class ContactInfoSeeder extends Seeder
{
   
    public function run(): void
    {
        // $contact_info = [

        //     [
            
        //     'name' => 'Asif Ahmed',
            
        //     'email' => 'asifahmed.mist@gmail.com',
            
        //     'message' => 'I like this store site',
            
        //     'contact_number' => '123456789',
            
        //     ],
            
        //     [
            
        //     'name' => 'Arshan Ahmad',
            
        //     'email' => 'aahmad@gmail.com',
            
        //     'message' => 'Need to entry more productd',
            
        //     'contact_number' => '987456321',
            
        //     ],
            
        //     ];
            
        //     foreach ($contact_info as $key => $value) {
            
        //     DB::table('contact_infos')->insert([
            
        //     $key => $value
            
        //     ]);
           
        
        ContactInfo::factory()->count(20)->create();
            }
    }

