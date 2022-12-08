<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * Получить навесное оборудование для выбора в select
     *
     * @return mixed
     */
    public function equipmentsListForSelect()
    {
        return Product::where(['type' => Product::TYPE_ATTACHED_EQUIPMENT])->get()->pluck('name', 'id');
    }
}
