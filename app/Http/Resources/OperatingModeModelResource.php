<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="OperatingModeModelResource")
 *
 * Class OperatingModeModelResource
 * @package App\Http\Resources
 */
class OperatingModeModelResource extends JsonResource
{
    /**
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
            'name' => $this->name,
            'value' => $this->value
        ];
    }
}
