<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktivnost extends Model
{
    protected $table = 'aktivnosti';

    protected $fillable = [
        'nazivAktivnosti',
        'rok',
        'opisAktivnosti',
        'projekatId',
        'poeni',
        'status',
    ];

    public function projekat()
    {
        return $this->belongsTo(Projekat::class, 'projekatId');
    }
}
