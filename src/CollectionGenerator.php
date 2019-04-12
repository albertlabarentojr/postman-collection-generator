<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\ConfigInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Interfaces\PersisterInterface;
use PostmanGenerator\Objects\CollectionItemObject;
use PostmanGenerator\Objects\CollectionObject;

class CollectionGenerator implements GeneratorInterface
{
    /**
     * @var \PostmanGenerator\Objects\CollectionObject
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
     * @param \PostmanGenerator\Objects\CollectionObject $collectionObject
     */
    public function __construct(CollectionObject $collectionObject)
    {
        $this->collectionObject = $collectionObject;
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
     */
    public function generate(): void
    {
        $this->getPersister()->persist($this->getConfig(), $this->collectionObject);
    }

    /**
     * Get collection.
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function getCollection(): CollectionObject
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
    private function getConfig(): ConfigInterface
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
