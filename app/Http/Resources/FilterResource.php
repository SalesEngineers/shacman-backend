<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="FilterResource")
 *
 * Class FilterResource
 * @package App\Http\Resources
 */
class FilterResource extends CharacteristicResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="boolean", property="is_active", title="Активная", description="Отобразить или скрыть категорию")
     * @OA\Property(type="array", property="options", title="Опции фильтра", @OA\Items(type="string"), example={"Опция 1","Опция 2","Опция 3"})
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $options = $this->options->unique('value')
                               ->map(function ($item) { return $item->value; })
                               ->sort()
                               ->values();

        return $this->when(
            count($options) || in_array($request->get('filter_empty', false), ['true', '1']),
            array_replace_recursive(parent::toArray($request), [
                'values' => $options
            ])
        );
    }
}
