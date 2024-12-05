<?php

namespace App\Http\Resources;

use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClanResurs extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'imePrezime' => $this->imePrezime,
            'email' => $this->email,
            'adresa' => $this->adresa,
            'telefon' => $this->telefon,
            'datumRodjenja' => $this->datumRodjenja,
            'pol' => $this->pol,
            'datumPristupa' => $this->datumPristupa,
            'datumIsteka' => $this->datumIsteka,
            'napomena' => $this->napomena,
            'slika' => $this->slika,
            'tim' => new TimResurs(Tim::find($this->timId)),
        ];
    }
}
