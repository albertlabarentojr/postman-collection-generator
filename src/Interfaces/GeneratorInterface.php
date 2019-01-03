<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\CollectionObject;

interface GeneratorInterface extends Serializable
{
    /**
     * Generate collection of objects as array.
     *
     * @return void
     */
    public function generate(): void;

    /**
     * Get all request collections.
     *
     * @return \App\Interfaces\CollectionRequestInterface[]
     */
    public function toArray(): array;

    /**
     * Get collection object.
     *
     * @return \App\Objects\CollectionObject
     */
    public function getCollection(): CollectionObject;
}
