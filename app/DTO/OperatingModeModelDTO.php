<?php

namespace App\DTO;

/**
 * @OA\Schema(title="OperatingModeModelDTO")
 *
 * Class OperatingModeModelDTO
 * @package App\DTO
 */
class OperatingModeModelDTO extends Model
{
    /**
     * @OA\Property(type="string", property="name", title="Название")
     *
     * День недели
     *
     * @var string $name
     */
    public $name;
    /**
     * @OA\Property(type="string", property="value", title="Значение")
     *
     * Время
     *
     * @var string $value
     */
    public $value;
    /**
     * Сортировка
     *
     * @var int $sort
     */
    public $sort;
}
