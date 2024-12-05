<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjekatResurs extends JsonResource
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
            'nazivProjekta' => $this->nazivProjekta,
            'datumPocetka' => $this->datumPocetka,
            'datumZavrsetka' => $this->datumZavrsetka,
            'opisProjekta' => $this->opisProjekta,
        ];
    }
}
