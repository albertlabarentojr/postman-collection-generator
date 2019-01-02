<?php
declare(strict_types=1);

namespace App;

use App\Interfaces\CollectionInterface;
use App\Interfaces\GeneratorInterface;
use App\Interfaces\SerializerInterface;
use App\Objects\CollectionItemObject;
use App\Objects\CollectionObject;

class CollectionGenerator implements GeneratorInterface
{
    /**
     * @var \App\Objects\CollectionObject
     */
    private $collectionObject;

    /**
     * @var \App\Interfaces\SerializerInterface
     */
    private $serializer;

    /**
     * CollectionGenerator constructor.
     *
     * @param \App\Objects\CollectionObject $collectionObject
     * @param \App\Interfaces\SerializerInterface $serializer
     */
    public function __construct(CollectionObject $collectionObject, SerializerInterface $serializer)
    {
        $this->collectionObject = $collectionObject;
        $this->serializer = $serializer;
    }

    /**
     * Add collection.
     *
     * @param string $collectionName
     *
     * @return \App\Interfaces\CollectionInterface
     */
    public function add(string $collectionName): CollectionInterface
    {
        $collectionItem = new CollectionItemObject();
        $collectionItem->setName($collectionName);

        $this->collectionObject->addItem($collectionItem);

        return new Collection($collectionItem);
    }

    /**
     * Get all request collections.
     *
     * @return \App\Interfaces\CollectionRequestInterface[]
     */
    public function toArray(): array
    {
        return $this->serializer->serialize($this->collectionObject);
    }

    /**
     * Generate collection of objects as array.
     *
     * @return mixed[]
     */
    public function generate(): array
    {
        return $this->toArray();
    }
}
