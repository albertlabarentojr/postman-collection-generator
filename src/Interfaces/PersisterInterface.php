<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\CollectionObject;
use PostmanGenerator\Schemas\CollectionSchema;

interface PersisterInterface
{
    /**
     * Get serializer.
     *
     * @return \PostmanGenerator\Interfaces\SerializerInterface
     */
    public function getSerializer(): SerializerInterface;

    /**
     * Persist collection for given config.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     * @param \PostmanGenerator\Schemas\CollectionSchema $collection
     *
     * @return void
     */
    public function persist(ConfigInterface $config, CollectionSchema $collection): void;
}
