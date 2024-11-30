<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivnostClana extends Model
{
    protected $table = 'aktivnosti_clanova';

    protected $fillable = [
        'aktivnostId',
        'clanId',
        'ocena',
    ];

    public function aktivnost()
    {
        return $this->belongsTo(Aktivnost::class, 'aktivnostId');
    }

    public function clan()
    {
        return $this->belongsTo(Clan::class, 'clanId');
    }
}
