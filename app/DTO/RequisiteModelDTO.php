<?php

namespace App\DTO;

/**
 * @OA\Schema(title="RequisiteModelDTO")
 *
 * Class RequisiteModelDTO
 * @package App\DTO
 */
class RequisiteModelDTO extends Model
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
}
