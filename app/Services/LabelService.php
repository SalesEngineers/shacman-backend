<?php

namespace App\Services;

use App\Models\Label;

class LabelService
{
    public function listForSelect()
    {
        return Label::all()->pluck('name', 'id');
    }
}