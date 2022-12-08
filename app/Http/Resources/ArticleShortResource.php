<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image_vertical = $this->when(
            $this->imageVertical && $this->imageVertical->url,
            new ImageResource($this->imageVertical),
            null
        );
        $image_horizontal = $this->when(
            $this->imageHorizontal && $this->imageHorizontal->url,
            new ImageResource($this->imageHorizontal),
            null
        );

        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'image_vertical' => $image_vertical,
            'image_horizontal' => $image_horizontal,
            'is_main' => $this->is_main,
            'published_at' => $this->published_at,
        ];
    }
}
