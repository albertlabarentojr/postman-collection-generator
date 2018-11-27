<?php
declare(strict_types=1);

namespace App\Interfaces;

interface Serializable
{
    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array;
}