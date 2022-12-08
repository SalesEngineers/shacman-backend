<?php

namespace App\Services;

use App\Models\Characteristic;

class CharacteristicService
{
    public function listForSelect()
    {
        return Characteristic::all()->pluck('name', 'id');
    }
}
