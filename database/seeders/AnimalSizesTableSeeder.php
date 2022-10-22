<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalSizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('animal_sizes')->truncate();

        DB::table('animal_sizes')->insert([
            ['id'=> 1,'name'=>'Pequeno'],
            ['id'=> 2,'name'=>'Médio'],
            ['id'=> 3,'name'=>'Grande'],
        ]);
    }
}
