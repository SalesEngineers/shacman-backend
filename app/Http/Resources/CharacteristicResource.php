<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="CharacteristicResource")
 *
 * Class CharacteristicResource
 * @package App\Http\Resources
 */
class CharacteristicResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="value", title="Значение")
     * @OA\Property(type="boolean", property="is_active", title="Активный")
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'sort'      => $this->sort,
            'is_active' => $this->is_active
        ];
    }
}
