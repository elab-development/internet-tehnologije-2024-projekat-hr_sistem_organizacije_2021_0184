<?php

namespace App\Http\Controllers;

class JsonController extends Controller
{
    public function uspesno($podaci, $poruka): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'uspesno' => true,
            'poruka' => $poruka,
            'podaci' => $podaci,
        ]);
    }

    public function neuspesno(string $poruka, array $greske = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'uspesno' => false,
            'poruka' => $poruka,
            'greske' => $greske,
        ]);
    }
}
