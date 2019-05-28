<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Http\Route;
use PostmanGenerator\Interfaces\ConfigInterface;
use PostmanGenerator\Interfaces\RouteInterface;

final class Config implements ConfigInterface
{
    /** @var string */
    private $baseUrl;

    /** @var string */
    private $exportDir;

    /** @var string */
    private $filename;

    /** @var bool */
    private $overrideExisting;

    /**
     * @var null|\PostmanGenerator\Interfaces\RouteInterface
     */
    private $route;

    /**
     * Config constructor.
     *
     * @param null|string $exportDir
     * @param null|string $filename
     * @param null|bool $overrideExisting
     * @param null|string $baseUrl
     * @param null|\PostmanGenerator\Interfaces\RouteInterface $route
     */
    public function __construct(
        ?string $exportDir = null,
        ?string $filename = null,
        ?bool $overrideExisting = null,
        ?string $baseUrl = null,
        ?RouteInterface $route = null
    ) {
        $this->exportDir = $exportDir ?? __DIR__;
        $this->filename = $filename ?? 'postman-collection';
        $this->overrideExisting = $overrideExisting ?? false;
        $this->baseUrl = $baseUrl ?? 'https://example.com/';
        $this->route = $route ?? new Route();
    }

    /**
     * Get base url.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Get dir to export collection.
     *
     * @return string
     */
    public function getExportDir(): string
    {
        return $this->exportDir;
    }

    /**
     * Get collection filename.
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Get route configuration as a service.
     *
     * @return \PostmanGenerator\Interfaces\RouteInterface
     */
    public function getRoute(): RouteInterface
    {
        return $this->route;
    }

    /**
     * Should existing collection be overridden or create a new one.
     *
     * @return bool
     */
    public function overrideExistingCollection(): bool
    {
        return $this->overrideExisting;
    }
}
