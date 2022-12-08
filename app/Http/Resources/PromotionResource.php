<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="PromotionResource")
 *
 * Class PromotionResource
 * @package App\Http\Resources
 */
class PromotionResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="content", title="Контент")
     * @OA\Property(type="object", property="image", title="Изображение", ref="#/components/schemas/ImageResource")
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
            'content' => $this->content,
            'image' => $this->when($this->image->is_active, new ImageResource($this->image), null)
        ];
    }
}
