<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\RequestObject;

interface RequestParserInterface
{
    public function parseRequest(): RequestObject;
}
