<?php

namespace App\DTO;

/**
 * @OA\Schema(title="MapModelDTO")
 *
 * Class MapModelDTO
 * @package App\DTO
 */
class MapModelDTO extends Model
{
    /**
     * @OA\Property(type="array", property="coords", title="Координаты", @OA\Items(), example={0,0})
     *
     * @var array
     */
    public $coords= [];
    /**
     * @OA\Property(type="integer", property="zoom", title="Зум", example="16")
     *
     * @var int
     */
    public $zoom = 16;
}
