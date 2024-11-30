<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projekat extends Model
{
    protected $table = 'projekti';

    protected $fillable = [
        'nazivProjekta',
        'datumPocetka',
        'datumZavrsetka',
        'opisProjekta',
    ];

    public function clanoviProjekta()
    {
        return $this->hasMany(ClanProjekta::class, 'projekatId');
    }
}
