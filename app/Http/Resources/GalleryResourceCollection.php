<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResourceCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name'   => $this->name,
            'images' => ImageResource::collection($this->images)
        ];
    }
}
