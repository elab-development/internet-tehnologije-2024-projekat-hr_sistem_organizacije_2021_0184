<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AktivnostResurs extends JsonResource
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
            'nazivAktivnosti' => $this->nazivAktivnosti,
            'rok' => $this->rok,
            'opisAktivnosti' => $this->opisAktivnosti,
            'projekat' => new ProjekatResurs($this->projekat),
            'poeni' => $this->poeni,
            'status' => $this->status,
        ];
    }
}
