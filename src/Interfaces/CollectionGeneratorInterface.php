<?php
declare(strict_types=1);

namespace App\Interfaces;

interface CollectionGeneratorInterface
{
    /**
     * Add collection.
     *
     * @param string $collectionName
     *
     * @return \App\Interfaces\CollectionRequestInterface
     */
    public function add(string $collectionName): CollectionRequestInterface;

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
