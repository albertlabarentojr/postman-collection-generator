<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface ConfigInterface
{
    /**
     * Get base url.
     *
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * Get dir to export collection.
     *
     * @return string
     */
    public function getExportDir(): string;

    /**
     * Get collection filename.
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Get route configuration as a service.
     *
     * @return \PostmanGenerator\Interfaces\RouteInterface
     */
    public function getRoute(): RouteInterface;

    /**
     * Should existing collection be overridden or create a new one.
     *
     * @return bool
     */
    public function overrideExistingCollection(): bool;
}
