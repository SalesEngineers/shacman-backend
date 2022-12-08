<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="AttachmentResource")
 *
 * Class AttachmentResource
 * @package App\Http\Resources
 */
class AttachmentResource extends JsonResource
{
    /**
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="url", title="Url")
     * @OA\Property(type="boolean", property="is_active", title="Активная")
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'      => $this->name,
            'url'       => $this->fullUrl,
            'is_active' => $this->is_active
        ];
    }
}
