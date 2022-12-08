<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="AdvantageResource")
 *
 * Class AdvantageResource
 * @package App\Http\Resources
 */
class AdvantageResource extends JsonResource
{
    /**
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="content", title="Контент")
     * @OA\Property(
     *     type="object",
     *     property="image",
     *     title="Изображение",
     *     @OA\Property(type="string", property="url"),
     *     @OA\Property(type="string", property="alt"),
     *     @OA\Property(type="string", property="title")
     * )
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'    => $this->name,
            'content' => $this->content,
            'image'   => $this->when($this->image_url, [
                'url' => $this->imageFullUrl,
                'alt' => $this->image_alt,
                'title' => $this->image_title
            ], null)
        ];
    }
}
