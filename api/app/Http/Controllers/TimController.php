<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimResurs;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimController extends JsonController
{
    public function vratiSveTimove()
    {
        $timovi = Tim::all();
        return $this->uspesno(TimResurs::collection($timovi), 'Timovi uspešno učitani.');
    }

    public function vratiTim($id)
    {
        $tim = Tim::find($id);
        if ($tim) {
            return $this->uspesno(new TimResurs($tim), 'Tim uspešno učitan.');
        }

        return $this->neuspesno('Tim nije pronađen.');
    }

    public function kreirajTim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nazivTima' => 'required|string|max:255',
            'skraceniNazivTima' => 'required|string|max:5',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $tim = new Tim();
        $tim->nazivTima = $request->nazivTima;
        $tim->skraceniNazivTima = $request->skraceniNazivTima;
        $tim->save();

        return $this->uspesno(new TimResurs($tim), 'Tim uspešno kreiran.');
    }

    public function azurirajTim(Request $request, $id)
    {
        $tim = Tim::find($id);
        if ($tim) {
            $validator = Validator::make($request->all(), [
                'nazivTima' => 'required|string|max:255',
                'skraceniNazivTima' => 'required|string|max:5',
            ]);

            if ($validator->fails()) {
                return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
            }

            $tim->nazivTima = $request->nazivTima;
            $tim->skraceniNazivTima = $request->skraceniNazivTima;
            $tim->save();

            return $this->uspesno(new TimResurs($tim), 'Tim uspešno ažuriran.');
        }

        return $this->neuspesno('Tim nije pronađen.');
    }

    public function obrisiTim($id)
    {
        $tim = Tim::find($id);
        if ($tim) {
            $tim->delete();
            return $this->uspesno(null, 'Tim uspešno obrisan.');
        }

        return $this->neuspesno('Tim nije pronađen.');
    }
}
