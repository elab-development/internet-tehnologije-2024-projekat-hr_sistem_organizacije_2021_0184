<?php

namespace App\Http\Controllers;

use App\Http\Resources\AktivnostClanaResurs;
use App\Models\AktivnostClana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AktivnostiClanaController extends JsonController
{
    public function index(Request $request)
    {
        $aktivnosti = AktivnostClana::all();
        return $this->uspesno(AktivnostClanaResurs::collection($aktivnosti), 'Aktivnosti clana pronadjene.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aktivnostId' => 'required',
            'clanId' => 'required',
            'ocena' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $aktivnostClana = new AktivnostClana();
        $aktivnostClana->aktivnostId = $request->aktivnostId;
        $aktivnostClana->clanId = $request->clanId;
        $aktivnostClana->ocena = $request->ocena;
        $aktivnostClana->save();

        return $this->uspesno(new AktivnostClanaResurs($aktivnostClana), 'Aktivnost clana je uspešno sačuvana.');
    }

    public function delete($id)
    {
        $aktivnostClana = AktivnostClana::find($id);

        if ($aktivnostClana) {
            $aktivnostClana->delete();
            return $this->uspesno(new AktivnostClanaResurs($aktivnostClana), 'Aktivnost clana je uspešno obrisana.');
        }

        return $this->neuspesno('Aktivnost clana nije pronađena.');
    }

    public function findByClan($clanId)
    {
        $aktivnostiClanova = AktivnostClana::where('clanId', $clanId)->get();

        return $this->uspesno(AktivnostClanaResurs::collection($aktivnostiClanova), 'Aktivnosti clana pronadjene.');
    }

    public function promeniOcenu(Request $request, $id)
    {
        $aktivnostClana = AktivnostClana::find($id);

        if ($aktivnostClana) {
            $aktivnostClana->ocena = $request->ocena;
            $aktivnostClana->save();
            return $this->uspesno(new AktivnostClanaResurs($aktivnostClana), 'Ocena aktivnosti je uspešno azurirana.');
        }

        return $this->neuspesno('Aktivnost clana nije pronađena.');
    }

}
