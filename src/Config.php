<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\ConfigInterface;

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
     * Config constructor.
     *
     * @param null|string $exportDir
     * @param null|string $filename
     * @param null|bool $overrideExisting
     * @param null|string $baseUrl
     */
    public function __construct(
        ?string $exportDir = null,
        ?string $filename = null,
        ?bool $overrideExisting = null,
        ?string $baseUrl = null
    ) {
        $this->exportDir = $exportDir ?? __DIR__;
        $this->filename = $filename ?? 'postman-collection';
        $this->overrideExisting = $overrideExisting ?? false;
        $this->baseUrl = $baseUrl ?? 'https://example.com/';
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
     * Should existing collection be overridden or create a new one.
     *
     * @return bool
     */
    public function overrideExistingCollection(): bool
    {
        return $this->overrideExisting;
    }
}
