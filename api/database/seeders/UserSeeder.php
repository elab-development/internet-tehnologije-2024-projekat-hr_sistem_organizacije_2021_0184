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
        $userAndjela = User::create([
            'email' => 'andjela@gmail.com',
            'password' => bcrypt('andjela123'),
            'ulogaUSistemu' => 'admin',
            'name' => 'Andjela'
        ]);

        $userEma = User::create([
            'email' => 'ema@gmail.com',
            'password' => bcrypt('ema123'),
            'ulogaUSistemu' => 'admin',
            'name' => 'Ema'
        ]);

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'ulogaUSistemu' => 'korisnik',
                'name' => $faker->name
            ]);
        }
    }
}
