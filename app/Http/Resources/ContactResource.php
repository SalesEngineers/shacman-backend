<?php

namespace App\Http\Resources;

use App\DTO\LinkModelDTO;
use App\DTO\OperatingModeContainer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="ContactResource")
 *
 * Class ContactResource
 * @package App\Http\Resources
 */
class ContactResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="object", property="phone", title="Телефон", ref="#/components/schemas/LinkModelDTO")
     * @OA\Property(type="object", property="email", title="E-mail", ref="#/components/schemas/LinkModelDTO")
     * @OA\Property(type="string", property="address", title="Адрес")
     * @OA\Property(type="array", property="operating_mode", title="Режим роботы", @OA\Items(ref="#/components/schemas/OperatingModeModelResource"))
     * @OA\Property(type="boolean", property="is_active", title="Активная")
     * @OA\Property(type="object", property="map", ref="#/components/schemas/MapModelDTO")
     *
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @throws \App\DTO\Exceptions\UnknownPropertyException
     * @throws \ReflectionException
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->url,
            'title' => $this->title,
            'content' => $this->content,
            'seo' => new SeoResource($this->seo),
            'images' => ImageResource::collection($this->images),
            'phone' => $this->when(
                $this->phone,
                new PhoneResource(
                    new LinkModelDTO([
                        'name'  => $this->phone,
                        'value' => clearPhone($this->phone),
                        'href'  => 'tel:' . clearPhone($this->phone)
                    ])
                ), null
            ),
            'email' => $this->when(
                $this->email,
                new EmailResource(
                    new LinkModelDTO([
                        'name' => $this->email,
                        'value' => $this->email,
                        'href' => 'mailto:' . $this->email
                    ])
                ),
                null
            ),
            'address' => $this->address,
            'operating_mode' => OperatingModeModelResource::collection(
                (new OperatingModeContainer($this->operating_mode))->list
            ),
            'is_active' => $this->is_active,
            'map' => [
                'coords' => $this->coords,
                'zoom' => $this->zoom
            ]
        ];
    }
}
