<?php
declare(strict_types=1);

namespace PostmanGenerator\Http;

final class RouteData
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $resource;

    /**
     * RouteData constructor.
     *
     * @param string $method
     * @param string $resource
     */
    public function __construct(string $method, string $resource)
    {
        $this->method = $method;
        $this->resource = $resource;
    }

    /**
     * Get method.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get resource path.
     *
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }
}
