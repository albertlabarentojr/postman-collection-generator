<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Exceptions\MissingConfigurationKeyException;
use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Interfaces\Serializable;
use PostmanGenerator\Interfaces\SerializerInterface;
use PostmanGenerator\Objects\CollectionItemObject;
use PostmanGenerator\Objects\CollectionObject;
use PostmanGenerator\Objects\Config\ConfigObject;

class CollectionGenerator implements GeneratorInterface
{
    /**
     * @var \PostmanGenerator\Objects\CollectionObject
     */
    private $collectionObject;

    /**
     * @var \PostmanGenerator\Objects\Config\ConfigObject
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
     * @param \PostmanGenerator\Objects\Config\ConfigObject $configuration
     */
    public function __construct(
        CollectionObject $collectionObject,
        SerializerInterface $serializer,
        ConfigObject $configuration
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
     * Export serializable object to .json file.
     *
     * @param string $filename
     * @param \PostmanGenerator\Interfaces\Serializable $serializable
     *
     * @return void
     */
    public function export(string $filename, Serializable $serializable): void
    {
        $file = \fopen($filename, 'wb');
        \fwrite($file, \json_encode($serializable->toArray()));
        \fclose($file);
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
        $exportDirectory = $this->configuration->getExportDirectory() ?? null;

        if ($exportDirectory === null) {
            throw new MissingConfigurationKeyException('Missing Configuration: [export_directory]');
        }

        $this->export($exportDirectory, $this);
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
