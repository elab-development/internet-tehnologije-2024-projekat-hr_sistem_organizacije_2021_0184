<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AktivnostiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $projekti = \App\Models\Projekat::all();

        for ($i = 0; $i < 50; $i++) {
            \App\Models\Aktivnost::create([
                'nazivAktivnosti' => $faker->sentence,
                'rok' => $faker->date(),
                'opisAktivnosti' => $faker->text,
                'projekatId' => $faker->randomElement($projekti)->id,
                'poeni' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['U toku', 'Inicijalizovana', 'Zavrsena'])
            ]);
        }
    }
}
