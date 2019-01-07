<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\CollectionObject;

interface GeneratorInterface extends Serializable
{
    /**
     * Export serializable object to .json file.
     *
     * @param string $filename
     * @param \PostmanGenerator\Interfaces\Serializable $serializable
     *
     * @return void
     */
    public function export(string $filename, Serializable $serializable): void;

    /**
     * Generate collection of objects as array.
     *
     * @return void
     */
    public function generate(): void;

    /**
     * Get collection object.
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function getCollection(): CollectionObject;

    /**
     * Get all request collections.
     *
     * @return \PostmanGenerator\Interfaces\CollectionRequestInterface[]
     */
    public function toArray(): array;
}
