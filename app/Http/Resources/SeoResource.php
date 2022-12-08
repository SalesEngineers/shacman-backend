<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="SeoResource")
 *
 * Class SeoResource
 * @package App\Http\Resources
 */
class SeoResource extends JsonResource
{
    /**
     * @OA\Property(type="string", property="title", title="Заголовок")
     * @OA\Property(type="string", property="description", title="Описание")
     * @OA\Property(type="string", property="keywords", title="Ключи")
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords
        ];
    }
}
