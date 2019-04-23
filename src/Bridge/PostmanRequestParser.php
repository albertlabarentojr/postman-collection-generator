<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge;

use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\HeaderSchema;
use PostmanGenerator\Schemas\RequestBodySchema;
use PostmanGenerator\Schemas\RequestSchema;

final class PostmanRequestParser implements RequestParserInterface
{
    /**
     * @var array
     */
    private $body;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var array|null
     */
    private $headers;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $url;

    /**
     * RequestParser constructor.
     *
     * @param string $method
     * @param string $url
     * @param mixed[] $body
     * @param null|mixed[] $headers
     * @param null|string $description
     */
    public function __construct(
        string $method,
        string $url,
        array $body,
        ?array $headers = null,
        ?string $description = null
    ) {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $this->parseHeader($headers);
        $this->body = $body;
        $this->description = $description;
    }

    /**
     * Parse request from given parameters.
     *
     * @return \PostmanGenerator\Schemas\RequestSchema
     */
    public function parseRequest(): RequestSchema
    {
        $headers = $this->headers ?? [];

        $headers[] = [
            new HeaderSchema([
                'key' => 'Content-Type',
                'name' => 'Content-Type',
                'value' => 'application/json',
                'type' => 'text'
            ])
        ];

        return new RequestSchema([
            'body' => new RequestBodySchema([
                'mode' => 'raw',
                'raw' => \json_encode($this->body)
            ]),
            'description' => new DescriptionSchema(['content' => $this->description]),
            'header' => $headers,
            'method' => $this->method,
            'url' => $this->url
        ]);
    }

    /**
     * Parse header array.
     *
     * @param mixed[] $headers
     *
     * @return \PostmanGenerator\Schemas\HeaderSchema[]
     */
    private function parseHeader(array $headers): array
    {
        $parsedHeader = [];

        foreach ($headers as $key => $value) {
            $parsedHeader[] = new HeaderSchema(
                \compact('key', 'value') + ['name' => $key, 'type' => 'text']
            );
        }

        return $parsedHeader;
    }
}
