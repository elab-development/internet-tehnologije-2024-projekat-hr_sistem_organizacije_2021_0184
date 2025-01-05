<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    protected $table = 'clanovi';

    protected $fillable = [
        'imePrezime',
        'user_id',
        'email',
        'adresa',
        'telefon',
        'datumRodjenja',
        'pol',
        'datumPristupa',
        'datumIsteka',
        'napomena',
        'slika',
        'timId',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'timId');
    }

    public function aktivnostiClana()
    {
        return $this->hasMany(AktivnostClana::class, 'clanId');
    }

    public function clanoviProjekata()
    {
        return $this->hasMany(ClanProjekta::class, 'clanId');
    }
}
