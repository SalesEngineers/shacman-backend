<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="DimensionResource")
 *
 * Class DimensionResource
 * @package App\Http\Resources
 */
class DimensionResource extends JsonResource
{
    /**
     * @OA\Property(type="string", property="width", title="Ширина")
     * @OA\Property(type="string", property="height", title="Высота")
     * @OA\Property(type="string", property="length", title="Длина")
     * @OA\Property(type="array", property="image_list", title="Список изображений", @OA\Items(type="string"))
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
            'length' => $this->length,
            'image_list' => $this->imageList
        ];
    }
}
