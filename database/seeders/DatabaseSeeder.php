<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('lt_LT');
        
        DB::table('users')->insert([
            'name' => 'darbuotojas',
            'email' => 'darbuotojas@gmail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jurgita',
            'email' => 'jurgita@bank.test',
            'password' => Hash::make('12345678'),
        ]);

       







    }
}
   

