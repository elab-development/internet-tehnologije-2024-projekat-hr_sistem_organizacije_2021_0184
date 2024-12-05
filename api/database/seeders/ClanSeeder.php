<?php

namespace Database\Seeders;

use App\Models\Tim;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'imePrezime',
        //        'email',
        //        'adresa',
        //        'telefon',
        //        'datumRodjenja',
        //        'pol',
        //        'datumPristupa',
        //        'datumIsteka',
        //        'napomena',
        //        'slika',
        //        'timId',

        $faker = \Faker\Factory::create();

        $timovi = Tim::all();

        for ($i = 0; $i < 50; $i++) {
            \App\Models\Clan::create([
                'imePrezime' => $faker->name,
                'email' => $faker->email,
                'adresa' => $faker->address,
                'telefon' => $faker->phoneNumber,
                'datumRodjenja' => $faker->date(),
                'pol' => $faker->randomElement(['M', 'Z']),
                'datumPristupa' => $faker->date(),
                'datumIsteka' => $faker->date(),
                'napomena' => $faker->text,
                'slika' => $faker->imageUrl(),
                'timId' => $faker->randomElement($timovi)->id
            ]);
        }
    }
}
