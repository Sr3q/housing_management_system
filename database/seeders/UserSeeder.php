<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        User::factory(30)->create();
        DB::table('users')->insert([
            'username' => 'admin',
            'name'=>'admin Name',
            'password' => Hash::make('12345678'),
        ]);
    }
}
