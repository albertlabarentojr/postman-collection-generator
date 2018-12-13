<?php
declare(strict_types=1);

namespace App\Interfaces;

interface SerializerInterface
{
    /**
     * Serialize an object entity as array.
     *
     * @param \App\Interfaces\Serializable $serializable
     *
     * @return mixed[]
     */
    public function serialize(Serializable $serializable): array;
}
