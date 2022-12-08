<?php

namespace App\DTO;

/**
 * @OA\Schema(title="SocialNetworksDTO")
 *
 * Class SocialNetworksDTO
 * @package App\DTO
 */
class SocialNetworksDTO extends Model
{
    /**
     * @OA\Property(type="string", property="name", title="Название")
     *
     * Название соц. сети
     *
     * @var string $name
     */
    public $name;
    /**
     * @OA\Property(type="string", property="icon", title="Иконка")
     *
     * Иконка
     *
     * @var string $icon
     */
    public $icon;
    /**
     * @OA\Property(type="string", property="url", title="Ссылка")
     *
     * Ссылка на соц. сеть
     *
     * @var string $url
     */
    public $url;
    /**
     * Сортировка
     *
     * @var int $sort
     */
    public $sort;
}
