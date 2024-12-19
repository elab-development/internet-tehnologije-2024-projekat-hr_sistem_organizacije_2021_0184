<?php

namespace App\Http\Controllers;

use App\Http\Resources\AktivnostResurs;
use App\Models\Aktivnost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AktivnostiController extends JsonController
{
    public function index()
    {
        $aktivnosti = Aktivnost::all();

        return $this->uspesno(AktivnostResurs::collection($aktivnosti), 'Sve aktivnosti.');
    }

    public function show($id)
    {
        $aktivnost = Aktivnost::find($id);

        if ($aktivnost) {
            return $this->uspesno($aktivnost, 'Aktivnost je pronađena.');
        }

        return $this->neuspesno('Aktivnost nije pronađena.');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nazivAktivnosti' => 'required',
            'rok' => 'required|date',
            'opisAktivnosti' => 'required',
            'projekatId' => 'required',
            'poeni' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $aktivnost = new Aktivnost();
        $aktivnost->nazivAktivnosti = $request->nazivAktivnosti;
        $aktivnost->rok = $request->rok;
        $aktivnost->opisAktivnosti = $request->opisAktivnosti;
        $aktivnost->projekatId = $request->projekatId;
        $aktivnost->poeni = $request->poeni;
        $aktivnost->status = $request->status;
        $aktivnost->save();

        return $this->uspesno(new AktivnostResurs($aktivnost), 'Aktivnost je uspešno sačuvana.');
    }

    public function delete($id)
    {

        $aktivnost = Aktivnost::find($id);

        if (!$aktivnost) {
            return $this->neuspesno('Aktivnost nije pronađena.');
        }

        $aktivnost->delete();

        return $this->uspesno($aktivnost, 'Aktivnost je uspešno obrisana.');
    }

    public function aktivnostiPoProjektu($projekatId)
    {
        $aktivnosti = Aktivnost::where('projekatId', $projekatId)->get();

        return $this->uspesno(AktivnostResurs::collection($aktivnosti), 'Aktivnosti projekta pronadjene.');
    }
}
