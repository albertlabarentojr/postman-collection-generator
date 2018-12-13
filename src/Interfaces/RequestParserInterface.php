<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\RequestObject;

interface RequestParserInterface
{
    public function parseRequest(): RequestObject;
}
