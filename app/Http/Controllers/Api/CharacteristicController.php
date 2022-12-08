<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CharacteristicResource;
use App\Models\Characteristic;
use Illuminate\Http\Request;

class CharacteristicController extends ApiController
{
    public function __invoke()
    {
        return CharacteristicResource::collection(Characteristic::orderBy('sort', 'asc')->get());
    }
}
