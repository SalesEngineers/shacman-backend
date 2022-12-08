<?php

namespace App\DTO;

class SocialNetworksContainer
{
    /**
     * @var SocialNetworksDTO[]
     */
    public $list = [];

    public function __construct(?array $list = null)
    {
        if (is_null($list) === false) {
            $this->list = collect($list)->mapInto(SocialNetworksDTO::class)->toArray();
        }
    }
}
