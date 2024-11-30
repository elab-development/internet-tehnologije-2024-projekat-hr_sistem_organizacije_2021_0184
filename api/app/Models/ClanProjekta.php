<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClanProjekta extends Model
{
    protected $table = 'clanovi_projekata';

    protected $fillable = [
        'clanId',
        'projekatId',
        'uloga'
    ];

    public function clan()
    {
        return $this->belongsTo(Clan::class, 'clanId');
    }

    public function projekat()
    {
        return $this->belongsTo(Projekat::class, 'projekatId');
    }
}
