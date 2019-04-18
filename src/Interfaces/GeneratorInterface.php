<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Schemas\CollectionSchema;

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
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function getCollection(): CollectionSchema;

    /**
     * Get all request collections.
     *
     * @return \PostmanGenerator\Interfaces\CollectionRequestInterface[]
     */
    public function toArray(): array;
}
