<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\RequestObject;

interface RequestParserInterface
{
    /**
     * Parse request from given data.
     *
     * @return \PostmanGenerator\Objects\RequestObject
     */
    public function parseRequest(): RequestObject;
}
