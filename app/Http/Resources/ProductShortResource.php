<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="ProductShortResource")
 *
 * Class ProductResource
 * @package App\Http\Resources
 */
class ProductShortResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="url", title="Url", description="По сути это slug")
     * @OA\Property(
     *     type="array",
     *     property="image",
     *     title="Изображения",
     *     @OA\Items(ref="#/components/schemas/ImageResource")
     * )
     * @OA\Property(type="array", property="characteristics", title="Характеристики", @OA\Items(ref="#/components/schemas/CharacteristicProductResource"))
     * @OA\Property(type="array", property="labels", title="Лейблы", @OA\Items(ref="#/components/schemas/LabelResource"))
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'images' => ImageResource::collection($this->images),
            'characteristics' => CharacteristicProductResource::collection($this->characteristics),
            'labels' => LabelResource::collection($this->labels),
            'is_out_of_production' => $this->is_out_of_production
        ];
    }
}
