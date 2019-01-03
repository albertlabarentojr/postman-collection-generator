<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Exceptions\MissingConfigurationKeyException;
use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Interfaces\SerializerInterface;
use PostmanGenerator\Objects\CollectionItemObject;
use PostmanGenerator\Objects\CollectionObject;

class CollectionGenerator implements GeneratorInterface
{
    /**
     * @var \PostmanGenerator\Objects\CollectionObject
     */
    private $collectionObject;

    /**
     * @var array|null
     */
    private $configuration;

    /**
     * @var \PostmanGenerator\Interfaces\SerializerInterface
     */
    private $serializer;

    /**
     * CollectionGenerator constructor.
     *
     * @param \PostmanGenerator\Objects\CollectionObject $collectionObject
     * @param \PostmanGenerator\Interfaces\SerializerInterface $serializer
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
     * @return \PostmanGenerator\Interfaces\CollectionInterface
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
     * @throws \PostmanGenerator\Exceptions\MissingConfigurationKeyException
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
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function getCollection(): CollectionObject
    {
        return $this->collectionObject;
    }

    /**
     * Get all request collections.
     *
     * @return \PostmanGenerator\Interfaces\CollectionRequestInterface[]
     */
    public function toArray(): array
    {
        return $this->serializer->serialize($this->collectionObject);
    }
}