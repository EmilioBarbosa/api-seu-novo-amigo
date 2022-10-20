<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('species')->truncate();

        DB::table('species')->insert([
            ['id' => 1, 'name' => 'Cachorro'],
            ['id' => 2, 'name' => 'Gato'],
        ]);
    }
}
