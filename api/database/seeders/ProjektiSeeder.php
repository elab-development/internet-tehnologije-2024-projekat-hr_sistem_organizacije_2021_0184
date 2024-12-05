<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjektiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'nazivProjekta',
        //        'datumPocetka',
        //        'datumZavrsetka',
        //        'opisProjekta',

        $projekti = [
            [
                'nazivProjekta' => 'KSON 2025',
                'datumPocetka' => '2025-10-23',
                'datumZavrsetka' => '2025-10-27',
                'opisProjekta' => 'Konferncija studenata nauke 2025'
            ],
            [
                'nazivProjekta' => 'Dani Prakse 2025',
                'datumPocetka' => '2025-03-23',
                'datumZavrsetka' => '2025-03-27',
                'opisProjekta' => 'Dani prakse za studente 2025'
            ],
            [
                'nazivProjekta' => 'NNI 2025',
                'datumPocetka' => '2025-01-25',
                'datumZavrsetka' => '2025-02-15',
                'opisProjekta' => 'Nedelja nagradnih igara'
            ],
            [
                'nazivProjekta' => 'SPORT BIZZ 2025',
                'datumPocetka' => '2025-05-23',
                'datumZavrsetka' => '2025-05-27',
                'opisProjekta' => 'Konferencija o sportu'
            ],
        ];

        foreach ($projekti as $projekat) {
            \App\Models\Projekat::create($projekat);
        }
    }
}
