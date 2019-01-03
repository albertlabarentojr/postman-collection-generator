<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\Serializable;
use PostmanGenerator\Interfaces\SerializerInterface;

class Serializer implements SerializerInterface
{
    /**
     * Serialize an object entity as array.
     *
     * @param mixed[]|\PostmanGenerator\Interfaces\Serializable $serializable
     *
     * @return mixed[]
     */
    public function serialize($serializable): array
    {
        if ($serializable instanceof Serializable) {
            $serializable = $serializable->toArray();
        }

        foreach ($serializable as $index => $arr) {
            if (($arr instanceof Serializable) === false && \is_array($arr) === false) {
                continue;
            }

            $serializable[$index] = $this->serialize($arr);
        }

        return $serializable;
    }
}
