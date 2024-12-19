<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClanProjektaResurs;
use App\Models\Projekat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClanoviProjektaController extends JsonController
{
    public function findByProjekat($projekatId)
    {
        $clanoviProjekta = DB::table('clanovi_projekata')
            ->join('clanovi', 'clanovi_projekata.clanId', '=', 'clanovi.id')
            ->join('projekti', 'clanovi_projekata.projekatId', '=', 'projekti.id')
            ->select('clanovi_projekata.*', 'clanovi.imePrezime', 'projekti.nazivProjekta', 'clanovi_projekata.id as clanProjektaId')
            ->where('projekti.id', '=', $projekatId)
            ->get();

        return $this->uspesno($clanoviProjekta, 'Clanovi projekta pronadjeni.');
    }

    public function findByClan($clanId)
    {
        $clanoviProjekta = DB::table('clanovi_projekata')
            ->join('clanovi', 'clanovi_projekata.clanId', '=', 'clanovi.id')
            ->join('projekti', 'clanovi_projekata.projekatId', '=', 'projekti.id')
            ->select('clanovi_projekata.*', 'clanovi.imePrezime', 'projekti.nazivProjekta', 'clanovi_projekata.id as clanProjektaId')
            ->where('clanovi.id', '=', $clanId)
            ->get();

        return $this->uspesno($clanoviProjekta, 'Projekti na kojima je clan radio pronadjeni.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clanId' => 'required',
            'projekatId' => 'required',
            'uloga' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prosla.', $validator->errors()->all());
        }

        $clanProjekta = new \App\Models\ClanProjekta();
        $clanProjekta->clanId = $request->clanId;
        $clanProjekta->projekatId = $request->projekatId;
        $clanProjekta->uloga = $request->uloga;
        $clanProjekta->save();

        return $this->uspesno(new ClanProjektaResurs($clanProjekta), 'Clan projekta je uspesno sacuvan.');
    }

    public function delete($id)
    {
        $clanProjekta = \App\Models\ClanProjekta::find($id);
        if (!$clanProjekta) {
            return $this->neuspesno('Clan projekta nije pronadjen.');
        }

        $clanProjekta->delete();

        return $this->uspesno(new ClanProjektaResurs($clanProjekta), 'Clan projekta je uspesno obrisan.');
    }

    public function paginate(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $clanoviProjekta = DB::table('clanovi_projekata')
            ->join('clanovi', 'clanovi_projekata.clanId', '=', 'clanovi.id')
            ->join('projekti', 'clanovi_projekata.projekatId', '=', 'projekti.id')
            ->select('clanovi_projekata.*', 'clanovi.imePrezime', 'projekti.nazivProjekta', 'clanovi_projekata.id as clanProjektaId')
            ->paginate($perPage);

        return $this->uspesno($clanoviProjekta, 'Clanovi projekta pronadjeni.');
    }
}
