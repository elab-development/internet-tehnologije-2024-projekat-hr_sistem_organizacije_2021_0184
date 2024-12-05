<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'nazivTima',
        //        'skraceniNazivTima',
        $timovi = [
            [
                'nazivTima' => 'Tim za dizajn',
                'skraceniNazivTima' => 'IT'
            ],
            [
                'nazivTima' => 'Tim za medjuljudske odnose',
                'skraceniNazivTima' => 'HR'
            ],
            [
                'nazivTima' => 'Tim za odnose sa javnoscu',
                'skraceniNazivTima' => 'PR'
            ],
            [
                'nazivTima' => 'Tim za koorporativne odnose',
                'skraceniNazivTima' => 'CR'
            ],
            [
                'nazivTima' => 'Tim za akademske odnose',
                'skraceniNazivTima' => 'AR'
            ],
        ];

        foreach ($timovi as $tim) {
            \App\Models\Tim::create($tim);
        }
    }
}
