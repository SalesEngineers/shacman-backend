<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="CharacteristicProductResource")
 *
 * Class CharacteristicProductResource
 * @package App\Http\Resources
 */
class CharacteristicProductResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="value", title="Значение")
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->characteristic->id,
            'name'            => $this->characteristic->name,
            'value'           => $this->value,
            'is_main'         => $this->characteristic->is_main,
            'groups'          => $this->when($this->characteristic->groups, function () {
                return new GroupResourceCollection($this->characteristic->groups);
            }, [])
        ];
    }
}
