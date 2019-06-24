<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Data;

final class RouteAction
{
    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $method;

    /**
     * RouteAction constructor.
     *
     * @param string $controller
     * @param string $method
     */
    public function __construct(string $controller, string $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
