<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjekatResurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjekatController extends JsonController
{
    public function index()
    {
        $projekti = \App\Models\Projekat::all();
        return $this->uspesno(ProjekatResurs::collection($projekti), 'Svi projekti.');
    }

    public function show($id)
    {
        $projekat = \App\Models\Projekat::find($id);
        if ($projekat) {
            return $this->uspesno($projekat, 'Projekat je pronađen.');
        }
        return $this->neuspesno('Projekat nije pronađen.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nazivProjekta' => 'required',
            'opisProjekta' => 'required',
            'datumPocetka' => 'required|date',
            'datumZavrsetka' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $projekat = new \App\Models\Projekat();
        $projekat->nazivProjekta = $request->nazivProjekta;
        $projekat->opisProjekta = $request->opisProjekta;
        $projekat->datumPocetka = $request->datumPocetka;
        $projekat->datumZavrsetka = $request->datumZavrsetka;
        $projekat->save();

        return $this->uspesno($projekat, 'Projekat je uspešno sačuvan.');
    }

    public function update(Request $request, $id)
    {
        $projekat = \App\Models\Projekat::find($id);
        if (!$projekat) {
            return $this->neuspesno('Projekat nije pronađen.');
        }

        $validator = Validator::make($request->all(), [
            'nazivProjekta' => 'required',
            'opisProjekta' => 'required',
            'datumPocetka' => 'required|date',
            'datumZavrsetka' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $projekat->nazivProjekta = $request->nazivProjekta;
        $projekat->opisProjekta = $request->opisProjekta;
        $projekat->datumPocetka = $request->datumPocetka;
        $projekat->datumZavrsetka = $request->datumZavrsetka;
        $projekat->save();

        return $this->uspesno($projekat, 'Projekat je uspešno ažuriran.');

    }

    public function destroy($id)
    {
        $projekat = \App\Models\Projekat::find($id);
        if (!$projekat) {
            return $this->neuspesno('Projekat nije pronađen.');
        }

        $projekat->delete();
        return $this->uspesno([], 'Projekat je uspešno obrisan.');
    }

}
