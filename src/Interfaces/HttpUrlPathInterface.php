<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Http\ResourceData;

interface HttpUrlPathInterface
{
    /** @var string */
    public const FILTER_FRAGMENT_ID = 'FILTER-FRAGMENT-ID';

    /** @var string */
    public const FILTER_FRAGMENT_NAME = 'FILTER-FRAGMENT-NAME';

    /**
     * Interpret a resource fragment into readable words.
     *
     * @param string $fragment
     *
     * @return \PostmanGenerator\Http\ResourceData
     */
    public function pathToResource(string $fragment): ResourceData;

    /**
     * Endpoint fragments separated by `/`.
     *
     * @param string $url
     *
     * @return string[]
     */
    public function getFragments(string $url): array;

    /**
     * Get resource id from resource.
     *
     * @param string $resourceName
     *
     * @return null|string
     */
    public function getResourceId(string $resourceName): ?string;

    /**
     * If fragment is a resource id.
     *
     * @param string $fragment
     *
     * @return bool
     */
    public function isResourceId(string $fragment): bool;

    /**
     * If fragment is a resource name.
     *
     * @param string $fragment
     *
     * @return string
     */
    public function isResourceName(string $fragment): string;
}
