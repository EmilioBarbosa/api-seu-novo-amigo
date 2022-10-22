<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $user = User::create([
            'name' => 'emilio barbosa',
            'email' => 'emiliobarbos4@gmail.com',
            'description'=> 'teste',
            'password'=> Hash::make('12345678'),
        ]);

        $user->phones()->create([
            'phone_number'=>'48984189420',
            'whatsapp' => true
        ]);

        $user->address()->create([
            'street' => 'Rua jaime bianchini',
            'neighborhood' => 'Pontal',
            'city_id' => 4595
        ]);

    }
}
