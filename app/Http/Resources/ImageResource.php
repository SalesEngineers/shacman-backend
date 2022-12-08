<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="ImageResource")
 *
 * Class ImageResource
 * @package App\Http\Resources
 */
class ImageResource extends JsonResource
{
    /**
     * @OA\Property(type="string", property="url", title="Url")
     * @OA\Property(type="string", property="alt", title="Альтернативный текст")
     * @OA\Property(type="string", property="title", title="Подсказка")
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'url' => $this->fullUrl,
            'alt' => $this->alt,
            'title' => $this->title
        ];
    }
}
