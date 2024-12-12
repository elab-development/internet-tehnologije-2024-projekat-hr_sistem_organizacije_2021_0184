<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends JsonController
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $korisnik = auth()->user();
            $token = $korisnik->createToken('Personal Access Token')->plainTextToken;
            return $this->uspesno(['token' => $token, 'user' => new UserResurs($korisnik)], 'Uspešno ste se prijavili.');
        }

        return $this->neuspesno('Pogrešni kredencijali.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->uspesno([], 'Uspešno ste se odjavili.');
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()){
            return $this->neuspesno('Validacija nije prošla.', $validator->errors()->all());
        }

        $korisnik = new \App\Models\User();
        $korisnik->name = $request->name;
        $korisnik->email = $request->email;
        $korisnik->password = bcrypt($request->password);
        $korisnik->ulogaUSistemu = 'korisnik';
        $korisnik->save();

        return $this->uspesno(new UserResurs($korisnik), 'Uspešno ste se registrovali.');
    }

}
