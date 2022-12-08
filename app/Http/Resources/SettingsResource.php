<?php

namespace App\Http\Resources;

use App\DTO\LinkModelDTO;
use App\DTO\OperatingModeContainer;
use App\DTO\RequisitesContainer;
use App\DTO\SocialNetworksContainer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="SettingsResource")
 *
 * Class SettingsResource
 * @package App\Http\Resources
 */
class SettingsResource extends JsonResource
{
    /**
     * @OA\Property(type="object", property="phone", title="Телефон", ref="#/components/schemas/LinkModelDTO")
     * @OA\Property(type="object", property="email", title="E-mail", ref="#/components/schemas/LinkModelDTO")
     * @OA\Property(type="string", property="address", title="Адрес")
     * @OA\Property(type="array", property="social_networks", title="Социальные сети", @OA\Items(ref="#/components/schemas/SocialNetworksResource"))
     * @OA\Property(type="array", property="operating_mode", title="Режим роботы", @OA\Items(ref="#/components/schemas/OperatingModeModelResource"))
     * @OA\Property(type="array", property="requisites", title="Реквизиты", @OA\Items(ref="#/components/schemas/RequisiteResource"))
     * @OA\Property(type="object", property="attachment", title="Файл", ref="#/components/schemas/AttachmentResource")
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
            'phone' => $this->when(
                $this->phone,
                new PhoneResource(
                    new LinkModelDTO([
                        'name'  => $this->phone,
                        'value' => clearPhone($this->phone),
                        'href'  => 'tel:' . clearPhone($this->phone)
                    ])
                ),
                null
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
            'address' => $this->when(
                $this->address,
                $this->address,
                null
            ),
            'social_networks' => SocialNetworksResource::collection(
                (new SocialNetworksContainer($this->social_networks))->list
            ),
            'operating_mode' => OperatingModeModelResource::collection(
                (new OperatingModeContainer($this->operating_mode))->list
            ),
            'requisites' => RequisiteResource::collection(
                (new RequisitesContainer($this->requisites))->requisites
            ),
            'attachment' => new AttachmentResource($this->attachment)
        ];
    }
}
