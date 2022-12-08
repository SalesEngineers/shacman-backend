<?php

namespace App\DTO;

class RequisitesContainer
{
    /**
     * @var RequisiteModelDTO[]
     */
    public $requisites = [];

    /**
     * Список реквизитов, перечисленные через \n (enter)
     * Заголовок отделяется ":"
     * Например, ИНН: 1234567890
     *
     * RequisitesContainer constructor.
     *
     * @param string $requisites
     */
    public function __construct(?string $requisites = null)
    {
        if (is_null($requisites) === false) {
            $this->requisites = parseFieldsFromStr($requisites, function ($title, $value) {
                return new RequisiteModelDTO(['name' => $title, 'value' => $value]);
            });
        }
    }
}
