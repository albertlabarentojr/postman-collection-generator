<?php
declare(strict_types=1);

namespace App\Interfaces;

interface GeneratorInterface extends Serializable
{
    /**
     * Generate collection of objects as array.
     *
     * @return mixed[]
     */
    public function generate(): array;

    /**
     * Get all request collections.
     *
     * @return \App\Interfaces\CollectionRequestInterface[]
     */
    public function toArray(): array;
}
