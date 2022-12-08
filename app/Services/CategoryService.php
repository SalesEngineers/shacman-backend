<?php

namespace App\Services;

class CategoryService
{
    /**
     * Получить список категорий для списа
     *
     * @param int|null $id
     * @return \Illuminate\Support\Collection
     */
    public function listForSelect(?int $id = null)
    {
        $query = \App\Models\Category::query();

        if ($id) {
            $query->where('id', '<>', $id);
        }

        return $query->get()->pluck('name', 'id');
    }
}
