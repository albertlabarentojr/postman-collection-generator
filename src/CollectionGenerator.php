<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\MissingConfigurationKeyException;
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
     * @var array|null
     */
    private $configuration;

    /**
     * @var \App\Interfaces\SerializerInterface
     */
    private $serializer;

    /**
     * CollectionGenerator constructor.
     *
     * @param \App\Objects\CollectionObject $collectionObject
     * @param \App\Interfaces\SerializerInterface $serializer
     * @param array|null $configuration
     */
    public function __construct(
        CollectionObject $collectionObject,
        SerializerInterface $serializer,
        ?array $configuration = null
    ) {
        $this->collectionObject = $collectionObject;
        $this->serializer = $serializer;
        $this->configuration = $configuration;
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
     * Generate collection of objects as array.
     *
     * @return void
     *
     * @throws \App\Exceptions\MissingConfigurationKeyException
     */
    public function generate(): void
    {
        $exportDirectory = $this->configuration['export_directory'] ?? null;

        if ($exportDirectory === null || empty($exportDirectory) === true) {
            throw new MissingConfigurationKeyException('Missing Configuration: [export_directory]');
        }

        $file = \fopen($this->configuration['export_directory'], 'wb');
        \fwrite($file, \json_encode($this->toArray()));
        \fclose($file);
    }

    /**
     * Get collection object.
     *
     * @return \App\Objects\CollectionObject
     */
    public function getCollection(): CollectionObject
    {
        return $this->collectionObject;
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
}
