<?php
declare(strict_types=1);

namespace PostmanGenerator\Parsers;

use PostmanGenerator\Interfaces\HeaderParserInterface;
use PostmanGenerator\Schemas\HeaderSchema;

final class HeaderParser implements HeaderParserInterface
{
    /**
     * @var null|array
     */
    private $exclude;

    /**
     * @var null|array
     */
    private $include;

    /**
     * HeaderParser constructor.
     *
     * @param null|string[] $include
     * @param null|string[] $exclude
     */
    public function __construct(?array $include = null, ?array $exclude = null)
    {
        $this->include = $include ?? [];
        $this->exclude = $exclude ?? [];
    }

    /**
     * Parse key-value headers and create HeaderSchema for each.
     *
     * @param mixed[] $headers
     *
     * @return \PostmanGenerator\Schemas\HeaderSchema[]
     */
    public function parse(array $headers): array
    {
        $parsedHeader = [];

        // Include overrides excludes
        if (empty($this->include) === false) {
            $this->exclude = [];
        }

        foreach ($headers as $key => $value) {
            if (empty($this->include) && empty($this->exclude)) {
                // Include everything.
                $parsedHeader[] = $this->createHeaderSchema($key, $value);

                continue;
            }

            $include = \in_array($key, $this->include, false) === true;
            $include = empty($this->include) ?: $include;

            $exclude = \in_array($key, $this->exclude, false) === true;
            if ($exclude === true || ($include === false && $exclude === false)) {
                continue;
            }

            $parsedHeader[] = $this->createHeaderSchema($key, $value);
        }

        return $parsedHeader;
    }

    /**
     * Create HeaderSchema object.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return \PostmanGenerator\Schemas\HeaderSchema
     */
    private function createHeaderSchema(string $key, $value): HeaderSchema
    {
        return new HeaderSchema([
            'disabled' => false,
            'key' => $key,
            'name' => $key,
            'type' => 'text',
            'value' => $value
        ]);
    }
}
