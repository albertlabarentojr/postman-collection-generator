<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface HttpRequestMethodInterface
{
    /** @var string */
    public const MESSAGE_SUCCESSFUL = 'Successful';

    /** @var string */
    public const METHOD_GET = 'GET';

    /** @var string */
    public const METHOD_PATCH = 'PATCH';

    /** @var string */
    public const METHOD_POST = 'POST';

    /** @var string */
    public const METHOD_PUT = 'PUT';
}
