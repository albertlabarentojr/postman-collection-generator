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
     * Get config.
     *
     * @return \PostmanGenerator\Interfaces\ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config ?? new Config();
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
