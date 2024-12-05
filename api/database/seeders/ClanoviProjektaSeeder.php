<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClanoviProjektaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'clanId',
        //        'projekatId',
        //        'uloga'

        $faker = \Faker\Factory::create();

        $clanovi = \App\Models\Clan::all();

        $projekti = \App\Models\Projekat::all();

        for ($i = 0; $i < 100; $i++) {
            \App\Models\ClanProjekta::create([
                'clanId' => $faker->randomElement($clanovi)->id,
                'projekatId' => $faker->randomElement($projekti)->id,
                'uloga' => $faker->randomElement(['Koordinator', 'Lider', 'Clan tima'])
            ]);
        }
    }
}
