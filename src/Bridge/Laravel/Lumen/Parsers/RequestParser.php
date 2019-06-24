<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Parsers;

use Illuminate\Http\Request;
use PostmanGenerator\Interfaces\HeaderParserInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Parsers\HeaderParser;
use PostmanGenerator\Schemas\RequestBodySchema;
use PostmanGenerator\Schemas\RequestSchema;

final class RequestParser implements RequestParserInterface
{
    /**
     * @var null|string
     */
    private $baseUrl;

    /**
     * @var \PostmanGenerator\Interfaces\HeaderParserInterface
     */
    private $headerParser;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @var null|string
     */
    private $uriOverride;

    /**
     * RequestParser constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param \PostmanGenerator\Interfaces\HeaderParserInterface $headerParser
     * @param null|string $baseUrl
     * @param null|string $uriOverride
     */
    public function __construct(
        Request $request,
        ?HeaderParserInterface $headerParser = null,
        ?string $baseUrl = null,
        ?string $uriOverride = null
    ) {
        $this->request = $request;
        $this->baseUrl = $baseUrl;
        $this->uriOverride = $uriOverride;
        $this->headerParser = $headerParser ?? new HeaderParser();
    }

    /**
     * Parse request from given data.
     *
     * @return \PostmanGenerator\Schemas\RequestSchema
     */
    public function parse(): RequestSchema
    {
        $headers = $this->headerParser->parse($this->request->headers->all());

        return new RequestSchema([
            'body' => new RequestBodySchema([
                'mode' => 'raw',
                'raw' => $this->request->getContent()
            ]),
            'header' => $headers,
            'method' => $this->request->getMethod(),
            'url' => $this->buildUri($this->baseUrl, $this->uriOverride ?? $this->request->getRequestUri())
        ]);
    }

    /**
     * Build uri from base and path.
     *
     * @param string $baseUrl
     * @param string $uriPath
     *
     * @return string
     */
    private function buildUri(string $baseUrl, string $uriPath): string
    {
        return \sprintf('%s/%s', \trim($baseUrl, '/'), \trim($uriPath, '/'));
    }
}
