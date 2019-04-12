<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\CollectionObject;

interface PersisterInterface
{
    /**
     * Persist collection for given config.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     * @param \PostmanGenerator\Objects\CollectionObject $collection
     *
     * @return void
     */
    public function persist(ConfigInterface $config, CollectionObject $collection): void;

    /**
     * Get serializer.
     *
     * @return \PostmanGenerator\Interfaces\SerializerInterface
     */
    public function getSerializer(): SerializerInterface;
}
