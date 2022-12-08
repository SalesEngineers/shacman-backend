<?php

namespace App\Services;

use App\Models\Promotion;

class PromotionService
{
    public function listForSelect()
    {
        return Promotion::all()->pluck('name', 'id');
    }
}
