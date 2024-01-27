<?php

namespace App\Services;

use App\Models\Characteristic;

class CharacteristicService
{
    public function listForSelect()
    {
        return Characteristic::all()->pluck('name', 'id');
    }

    public function listForSelectWithGroup()
    {
        $list = Characteristic::query()->with(['groups:name'])->get(['id', 'name']);
        return $list->mapWithKeys(function ($item) {
            $groups = $item->groups->map(function ($item) { return $item->name; });
			$g = '';
			
			if ($groups->isEmpty() === false) {
				$g = ' [' . implode(' | ', $groups->toArray()) . ']';
			}
			
            return [$item->id => $item->name . $g];
        });
    }
}
