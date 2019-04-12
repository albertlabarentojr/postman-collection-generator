<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\CollectionObject;

interface GeneratorInterface extends Serializable
{
    /**
     * Generate collection of objects as array.
     *
     * @return void
     */
    public function generate(): void;

    /**
     * Get collection.
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function getCollection(): CollectionObject;

    /**
     * Set config.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     *
     * @return \PostmanGenerator\Interfaces\GeneratorInterface
     */
    public function setConfig(ConfigInterface $config): self;

    /**
     * Set persister.
     *
     * @param \PostmanGenerator\Interfaces\PersisterInterface $persister
     *
     * @return \PostmanGenerator\Interfaces\GeneratorInterface
     */
    public function setPersister(PersisterInterface $persister): self;
}
