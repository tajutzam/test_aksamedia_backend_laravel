<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create(
            [
                'username' => 'admin',
                'name' => 'admin aksamedia',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('pasti bisa'),
                'phone' => '085607185972'
            ]
        );
    }
}
