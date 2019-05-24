<?php
declare(strict_types=1);

namespace PostmanGenerator\Http;

final class ResourceData
{
    /**
     * @var null|string
     */
    private $description;

    /**
     * @var string
     */
    private $nestedResource;

    /**
     * @var string
     */
    private $resource;

    /**
     * PathData constructor.
     *
     * @param string $nestedResource
     * @param string $resource
     * @param null|string $description
     */
    public function __construct(string $nestedResource, string $resource, ?string $description = null)
    {
        $this->nestedResource = $nestedResource;
        $this->resource = $resource;
        $this->description = $description;
    }

    /**
     * Get nested resource.
     *
     * @return string
     */
    public function getNestedResource(): string
    {
        return $this->nestedResource;
    }

    /**
     * Get resource.
     *
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * Get description.
     *
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
