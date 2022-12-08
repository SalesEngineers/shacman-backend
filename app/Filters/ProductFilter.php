<?php

namespace App\Filters;

class ProductFilter extends QueryFilter
{
    public function filterC($characteristics)
    {
        if (is_array($characteristics)) {
            $index = 1;

            foreach ($characteristics as $id => $value) {
                if (empty($id) || empty($value)) continue;

                $t = getNameFromNumber($index);

                $this->builder
                    ->leftJoin(
                        "characteristic_products as {$t}",
                        "{$t}.product_id",
                        '=',
                        'products.id'
                    );

                $this->builder->where(function ($query) use ($id, $value, $t) {
                    $query->where("{$t}.characteristic_id", $id)
                          ->where("{$t}.value", 'like', '%'.$value.'%');
                });

                $index++;
            }
        }
    }
}
