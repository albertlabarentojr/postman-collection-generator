<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Exceptions\MissingConfigurationKeyException;
use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Interfaces\Serializable;
use PostmanGenerator\Interfaces\SerializerInterface;
use PostmanGenerator\Schemas\CollectionItemSchema;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\Config\ConfigObject;

class CollectionGenerator implements GeneratorInterface
{
    /**
     * @var \PostmanGenerator\Schemas\CollectionSchema
     */
    private $collectionObject;

    /**
     * @var \PostmanGenerator\Schemas\Config\ConfigObject
     */
    private $configuration;

    /**
     * @var \PostmanGenerator\Interfaces\SerializerInterface
     */
    private $serializer;

    /**
     * CollectionGenerator constructor.
     *
     * @param \PostmanGenerator\Schemas\CollectionSchema $collectionObject
     * @param \PostmanGenerator\Interfaces\SerializerInterface $serializer
     * @param \PostmanGenerator\Schemas\Config\ConfigObject $configuration
     */
    public function __construct(
        CollectionSchema $collectionObject,
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
        $collectionItem = new CollectionItemSchema();
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
        $collectionData = $serializable->toArray();

        if ($this->configuration->isOverrideExisting() === true) {
            $this->updateCurrentCollection($filename, $collectionData);
        }

        $file = \fopen($filename, 'wb');
        \fwrite($file, \json_encode($collectionData));
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
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function getCollection(): CollectionSchema
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

    /**
     * Update items for current exported collection.
     *
     * @param string $filename
     * @param mixed[] $collectionData
     *
     * @return void
     */
    private function updateCurrentCollection(string $filename, array &$collectionData): void
    {
        if (\file_exists($filename) === true) {
            $currentCollection = \json_decode(\file_get_contents($filename), true);
            $collectionData['item'] = \array_merge($currentCollection['item'] ?? [], $collectionData['item'] ?? []);
        }
    }
}
