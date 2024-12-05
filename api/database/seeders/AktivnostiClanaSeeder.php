<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AktivnostiClanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'aktivnostId',
        //        'clanId',
        //        'ocena',

        $faker = \Faker\Factory::create();

        $aktivnosti = \App\Models\Aktivnost::all();

        $clanovi = \App\Models\Clan::all();

        for ($i = 0; $i < 100; $i++) {
            $aktivnost = $faker->randomElement($aktivnosti);
            \App\Models\AktivnostClana::create([
                'aktivnostId' => $aktivnost->id,
                'clanId' => $faker->randomElement($clanovi)->id,
                'ocena' => $faker->numberBetween(1, $aktivnost->poeni)
            ]);
        }
    }
}
