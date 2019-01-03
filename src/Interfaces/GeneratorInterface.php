<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\CollectionObject;

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
     * @return \PostmanGenerator\Interfaces\CollectionRequestInterface[]
     */
    public function toArray(): array;

    /**
     * Get collection object.
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function getCollection(): CollectionObject;
}
