<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClanProjektaResurs extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'clan' => new ClanResurs($this->clan),
            'projekat' => new ProjekatResurs($this->projekat),
            'uloga' => $this->uloga,
            'id' => $this->id,
        ];
    }
}
