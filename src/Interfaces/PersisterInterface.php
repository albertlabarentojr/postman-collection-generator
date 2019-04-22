<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Schemas\CollectionSchema;

interface PersisterInterface
{
    /**
     * Get cached collection schema.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     *
     * @return null|\PostmanGenerator\Schemas\CollectionSchema
     */
    public function getCachedCollection(ConfigInterface $config): ?CollectionSchema;

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
