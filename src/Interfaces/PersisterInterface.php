<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Config;
use PostmanGenerator\Objects\CollectionObject;
use PostmanGenerator\Schemas\CollectionSchema;

interface PersisterInterface
{
    /**
     * Persist collection for given config.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     * @param \PostmanGenerator\Schemas\CollectionSchema $collection
     *
     * @return void
     */
    public function persist(ConfigInterface $config, CollectionSchema $collection): void;

    /**
     * Get serializer.
     *
     * @return \PostmanGenerator\Interfaces\SerializerInterface
     */
    public function getSerializer(): SerializerInterface;
}
