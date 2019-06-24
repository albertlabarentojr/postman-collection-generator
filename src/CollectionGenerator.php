<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\ConfigInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Interfaces\PersisterInterface;
use PostmanGenerator\Schemas\CollectionItemSchema;
use PostmanGenerator\Schemas\CollectionSchema;

class CollectionGenerator implements GeneratorInterface
{
    /**
     * @var \PostmanGenerator\Schemas\CollectionSchema
     */
    private $collectionObject;

    /**
     * @var \PostmanGenerator\Interfaces\ConfigInterface
     */
    private $config;

    /**
     * @var \PostmanGenerator\Interfaces\PersisterInterface
     */
    private $persister;

    /** @var mixed[] */
    private $savedFillable = [];

    /**
     * CollectionGenerator constructor.
     *
     * @param \PostmanGenerator\Schemas\CollectionSchema $collectionObject
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     */
    public function __construct(CollectionSchema $collectionObject, ConfigInterface $config)
    {
        $this->config = $config;

        $this->collectionObject = $this
                ->getPersister()
                ->getCachedCollection($config) ?? $collectionObject;
    }

    /**
     * Add collection.
     *
     * @param string $collectionName
     *
     * @param null|mixed[] $config
     *
     * @return \PostmanGenerator\Interfaces\CollectionInterface
     *
     * @deprecated
     */
    public function add(string $collectionName, ?array $config = null): CollectionInterface
    {
        return $this->createCollection($collectionName, $config);
    }

    /**
     * Create a collection from name.
     *
     * @param string $collectionName
     *
     * @param array|null $config
     *
     * @return \PostmanGenerator\Interfaces\CollectionInterface
     */
    public function createCollection(string $collectionName, ?array $config = null): CollectionInterface
    {
        $collectionNames = \explode('.', $collectionName);

        if ($config !== null) {
            $this->savedFillable = $config;
        }

        $collectionItem = new CollectionItemSchema();

        $collection = new Collection($collectionItem);

        foreach ($collectionNames as $index => $name) {
            if ($index === 0) {
                $collectionItem->setName($name);
                $collectionItem->fill($this->savedFillable);
                $this->collectionObject->addItem($collectionItem);

                continue;
            }

            $collection = $collection->addSubCollection($name);
        }

        return $collection;
    }

    /**
     * Generate collection of objects as array.
     *
     * @return void
     */
    public function generate(): void
    {
        $this->getPersister()->persist($this->getConfig(), $this->collectionObject);
    }

    /**
     * Get collection.
     *
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function getCollection(): CollectionSchema
    {
        return $this->collectionObject;
    }

    /**
     * Get config.
     *
     * @return \PostmanGenerator\Interfaces\ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config ?? new Config();
    }

    /**
     * Set config.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     *
     * @return \PostmanGenerator\Interfaces\GeneratorInterface
     */
    public function setConfig(ConfigInterface $config): GeneratorInterface
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set persister.
     *
     * @param \PostmanGenerator\Interfaces\PersisterInterface $persister
     *
     * @return \PostmanGenerator\Interfaces\GeneratorInterface
     */
    public function setPersister(PersisterInterface $persister): GeneratorInterface
    {
        $this->persister = $persister;

        return $this;
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return $this->getPersister()->getSerializer()->serialize($this->collectionObject);
    }

    /**
     * Get persister.
     *
     * @return \PostmanGenerator\Interfaces\PersisterInterface
     */
    private function getPersister(): PersisterInterface
    {
        return $this->persister ?? new Persister();
    }
}
