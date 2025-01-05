<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClanResurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClanController extends JsonController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $clanovi = \App\Models\Clan::all();
        return $this->uspesno(ClanResurs::collection($clanovi), 'Uspesno ucitani clanovi');
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $clan = \App\Models\Clan::find($id);
        if ($clan === null) {
            return $this->neuspesno('Clan nije pronadjen');
        }
        return $this->uspesno(new ClanResurs($clan), 'Uspesno ucitan clan');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'imePrezime' => 'required',
            'email' => 'required|email',
            'adresa' => 'required',
            'telefon' => 'required',
            'datumRodjenja' => 'required',
            'pol' => 'required',
            'datumPristupa' => 'required',
            'datumIsteka' => 'required',
            'napomena' => 'required',
            'timId' => 'required|int',
            'slikaFajl' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        //slika is url to image
        $slika = $request->file('slikaFajl');
        $slikaIme = time() . '.' . $slika->getClientOriginalExtension();
        $slika->move(public_path('images'), $slikaIme);
        $imageUrl = url('images/' . $slikaIme);


        $clan = new \App\Models\Clan();
        $clan->imePrezime = $request->input('imePrezime');
        $clan->email = $request->input('email');
        $clan->adresa = $request->input('adresa');
        $clan->telefon = $request->input('telefon');
        $clan->datumRodjenja = $request->input('datumRodjenja');
        $clan->pol = $request->input('pol');
        $clan->datumPristupa = $request->input('datumPristupa');
        $clan->datumIsteka = $request->input('datumIsteka');
        $clan->napomena = $request->input('napomena');
        $clan->slika = $imageUrl;
        $clan->timId = $request->input('timId');
        $clan->save();

        return $this->uspesno(new ClanResurs($clan), 'Uspesno kreiran clan');
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $clan = \App\Models\Clan::find($id);
        if ($clan === null) {
            return $this->neuspesno('Clan nije pronadjen');
        }

        $validator = Validator::make($request->all(), [
            'imePrezime' => 'required',
            'email' => 'required|email',
            'adresa' => 'required',
            'telefon' => 'required',
            'datumRodjenja' => 'required',
            'pol' => 'required',
            'datumPristupa' => 'required',
            'datumIsteka' => 'required',
            'napomena' => 'required',
            'timId' => 'required|int',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $clan->imePrezime = $request->input('imePrezime');
        $clan->email = $request->input('email');
        $clan->adresa = $request->input('adresa');
        $clan->telefon = $request->input('telefon');
        $clan->datumRodjenja = $request->input('datumRodjenja');
        $clan->pol = $request->input('pol');
        $clan->datumPristupa = $request->input('datumPristupa');
        $clan->datumIsteka = $request->input('datumIsteka');
        $clan->napomena = $request->input('napomena');
        $clan->timId = $request->input('timId');
        $clan->save();

        return $this->uspesno($clan, 'Uspesno azuriran clan');
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $clan = \App\Models\Clan::find($id);
        if ($clan === null) {
            return $this->neuspesno('Clan nije pronadjen');
        }
        $clan->delete();
        return $this->uspesno($clan, 'Uspesno obrisan clan');
    }

    public function pretraziPoTimu($timId): \Illuminate\Http\JsonResponse
    {
        $clanovi = \App\Models\Clan::where('timId', $timId)->get();
        return $this->uspesno(ClanResurs::collection($clanovi), 'Uspesno pronadjeni clanovi');
    }

    public function grupisiPoTimu(): \Illuminate\Http\JsonResponse
    {
        $timovi = DB::table('clanovi')
            ->join('timovi', 'clanovi.timId', '=', 'timovi.id')
            ->select( 'timovi.nazivTima', DB::raw('count(*) as brojClanova'))
            ->groupBy('timovi.nazivTima')
            ->get();
        return $this->uspesno($timovi, 'Uspesno grupisani clanovi po timu');
    }

    public function nadjiClanaPoUserIdu($userId): \Illuminate\Http\JsonResponse
    {
        $clan = \App\Models\Clan::where('user_id', $userId)->first();
        if ($clan === null) {
            return $this->neuspesno('Clan nije pronadjen');
        }
        return $this->uspesno(new ClanResurs($clan), 'Uspesno pronadjen clan');
    }

    public function poveziUseraSaClanom($clanId, $userId): \Illuminate\Http\JsonResponse
    {
        $clan = \App\Models\Clan::find($clanId);
        if ($clan === null) {
            return $this->neuspesno('Clan nije pronadjen');
        }

        $clan->user_id = $userId;
        $clan->save();

        return $this->uspesno(new ClanResurs($clan), 'Uspesno povezan clan sa userom');
    }
}
