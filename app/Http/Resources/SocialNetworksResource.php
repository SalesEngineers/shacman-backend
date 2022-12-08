<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="SocialNetworksResource")
 *
 * Class SocialNetworksResource
 * @package App\Http\Resources
 */
class SocialNetworksResource extends JsonResource
{
    /**
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="url", title="Ссылка на соц. сеть")
     * @OA\Property(type="string", property="icon", title="Иконка")
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
            'url' => $this->url,
            'icon' => $this->icon,
        ];
    }
}
