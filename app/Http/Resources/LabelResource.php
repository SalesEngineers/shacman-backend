<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="LabelResource")
 *
 * Class LabelResource
 * @package App\Http\Resources
 */
class LabelResource extends JsonResource
{
    /**
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="color", title="Цвет")
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
            'color' => $this->color,
            'noindex' => $this->noindex
        ];
    }
}
