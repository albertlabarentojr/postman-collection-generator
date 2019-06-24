<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Schemas\RequestSchema;

interface RequestParserInterface
{
    /**
     * Parse request from given data.
     *
     * @return \PostmanGenerator\Schemas\RequestSchema
     */
    public function parse(): RequestSchema;
}
