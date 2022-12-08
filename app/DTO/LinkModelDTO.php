<?php

namespace App\DTO;

/**
 * @OA\Schema(title="LinkModelDTO")
 *
 * Class LinkModelDTO
 * @package App\DTO
 */
class LinkModelDTO extends Model
{
    /**
     * @OA\Property(type="string", property="name", title="Название")
     *
     * @var string $name
     */
    public $name;
    /**
     * @OA\Property(type="string", property="value", title="Значение")
     *
     * @var string $value
     */
    public $value;
    /**
     * @OA\Property(type="string", property="href", title="Атрибут")
     *
     * @var string $href
     */
    public $href;
}
