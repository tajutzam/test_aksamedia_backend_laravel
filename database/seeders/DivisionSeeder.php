<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $names = [
            'Mobile Apps' ,'QA' , 'Full Stack' , 'Backend' , 'Frontend' , 'UI/UX','Designer'
        ];

        foreach ($names as $key => $value) {
            # code...
            Division::create([
                'name' => $value
            ]);
        }
    }
}
