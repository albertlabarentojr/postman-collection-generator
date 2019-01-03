<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface SerializerInterface
{
    /**
     * Serialize an object entity as array.
     *
     * @param \PostmanGenerator\Interfaces\Serializable $serializable
     *
     * @return mixed[]
     */
    public function serialize(Serializable $serializable): array;
}
