<?php

namespace App\DTO\Exceptions;

class UnknownPropertyException extends \Exception
{
    public function getName(): string
    {
        return 'Unknown Property';
    }
}
