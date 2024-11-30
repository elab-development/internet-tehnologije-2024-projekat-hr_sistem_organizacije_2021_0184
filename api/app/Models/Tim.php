<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'timovi';

    protected $fillable = [
        'nazivTima',
        'skraceniNazivTima',
    ];

    public function clanovi()
    {
        return $this->hasMany(Clan::class, 'timId');
    }
}
