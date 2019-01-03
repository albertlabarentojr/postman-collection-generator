<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface FillableCollectionInterface
{
    /**
     * Add configuration to collection object
     *
     * @param array $config
     *
     * @return void
     */
    public function addConfig(array $config): void;
}
