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

        $aktivnosti = [
            "Postavljanje standa",
            "Nosenje kutija",
            "Anketiranje",
            "Pisanje izvestaja",
            "Pisanje plana",
            "Pisanje analize",
            "Organizacija sastanka",
            "Organizacija timbildinga",
        ];

        foreach ($aktivnosti as $aktivnost) {
            \App\Models\Aktivnost::create([
                'nazivAktivnosti' => $aktivnost,
                'rok' => $faker->dateTimeBetween('+1 week', '+2 month')->format('Y-m-d'),
                'opisAktivnosti' => $faker->text,
                'projekatId' => $faker->randomElement($projekti)->id,
                'poeni' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['U toku', 'Inicijalizovana', 'Zavrsena'])
            ]);
        }
        
    }
}
