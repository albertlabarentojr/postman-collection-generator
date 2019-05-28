<?php
declare(strict_types=1);

namespace PostmanGenerator\Http;

use PostmanGenerator\Interfaces\HttpUrlPathInterface;

final class UrlPath implements HttpUrlPathInterface
{
    /**
     * Endpoint fragments separated by `/`.
     *
     * @param string $url
     *
     * @return string[]
     */
    public function getFragments(string $url): array
    {
        // TODO: Implement getFragments() method.
    }

    /**
     * Get resource id from resource.
     *
     * @param string $resourceName
     *
     * @return null|string
     */
    public function getResourceId(string $resourceName): ?string
    {
        // TODO: Implement getResourceId() method.
    }

    /**
     * If fragment is a resource id.
     *
     * @param string $fragment
     *
     * @return bool
     */
    public function isResourceId(string $fragment): bool
    {
        // TODO: Implement isResourceId() method.
    }

    /**
     * If fragment is a resource name.
     *
     * @param string $fragment
     *
     * @return string
     */
    public function isResourceName(string $fragment): string
    {
        // TODO: Implement isResourceName() method.
    }

    /**
     * Interpret a resource fragment into readable words.
     *
     * @param string $fragment
     * @param null|string $httpMethod
     *
     * @return \PostmanGenerator\Http\ResourceData
     */
    public function pathToResource(string $fragment, ?string $httpMethod = null): ResourceData
    {
        // TODO: Implement fragmentToResource() method.
    }
}
