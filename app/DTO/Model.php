<?php

namespace App\DTO;

use ReflectionException;
use ReflectionProperty;
use App\DTO\Exceptions\UnknownPropertyException;

abstract class Model
{
    /**
     * Entity constructor.
     *
     * @param array $properties
     *
     * @throws ReflectionException
     * @throws UnknownPropertyException
     */
    public function __construct(array $properties = [])
    {
        if (\count($properties) > 0) {
            $this->setProperties($properties);
        }
    }

    /**
     * @return ReflectionProperty[]
     * @throws ReflectionException
     */
    protected function getProperties(): array
    {
        $reflect = new \ReflectionClass(static::class);
        return $reflect->getProperties( ReflectionProperty::IS_PUBLIC);
    }

    /**
     * @param array $properties
     *
     * @throws ReflectionException
     * @throws UnknownPropertyException
     */
    protected function setProperties(array $properties)
    {
        foreach ($this->getProperties() as $prop) {
            $name = $prop->getName();

            if (key_exists($name, $properties)) {
                $this->$name = $properties[$name];
            } else {
                throw new UnknownPropertyException('Свойство ' . $name . ' не существует в конфиге.');
            }
        }
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function toArray()
    {
        $props = [];

        foreach ($this->getProperties() as $prop) {
            $props[$prop->getName()] = $prop->getValue($this);
        }

        return $props;
    }
}
