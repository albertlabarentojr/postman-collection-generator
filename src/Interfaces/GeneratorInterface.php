<?php
declare(strict_types=1);

namespace App\Interfaces;

interface GeneratorInterface
{
    /**
     * Add collection.
     *
     * @param string $collectionName
     *
     * @return \App\Interfaces\CollectionInterface
     */
    public function add(string $collectionName): CollectionInterface;

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
    public function all(): array;
}
