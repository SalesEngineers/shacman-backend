<?php

namespace App\DTO;

class OperatingModeContainer
{
    /**
     * @var OperatingModeModelDTO[]
     */
    public $list = [];

    public function __construct(?array $list = null)
    {
        if (is_null($list) === false) {
            $this->list = collect($list)->mapInto(OperatingModeModelDTO::class)->toArray();
        }
    }
}
