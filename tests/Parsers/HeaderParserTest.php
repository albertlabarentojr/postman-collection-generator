<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Parsers;

use PostmanGenerator\Parsers\HeaderParser;
use PostmanGenerator\Schemas\HeaderSchema;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Parsers\HeaderParser
 */
final class HeaderParserTest extends TestCase
{
    /**
     * Test parse with empty options and will include everything.
     *
     * @return void
     */
    public function testParseEmptyOptionsIncludesEverything(): void
    {
        $headerParser = new HeaderParser(null, null);

        $parsedHeaders = $headerParser->parse([
            'accept-language' => 'en-us,en;q=0.5',
            'content-type' => 'application/x-www-form-urlencoded'
        ]);

        self::assertCount(2, $parsedHeaders);
    }

    /**
     * Test parse excludes header values.
     *
     * @return void
     */
    public function testParseExcludeOnly(): void
    {
        $exclude = ['accept-language'];

        $headerParser = new HeaderParser(null, $exclude);

        $parsedHeaders = $headerParser->parse([
            'accept-language' => 'en-us,en;q=0.5',
            'content-type' => 'application/x-www-form-urlencoded'
        ]);

        self::assertCount(1, $parsedHeaders);
    }

    /**
     * Test parse with options includes and excludes.
     *
     * @return void
     */
    public function testParseWithIncludesAndExcludes(): void
    {
        $include = ['content-type', 'accept'];
        $exclude = ['accept-language'];

        $headerParser = new HeaderParser($include, $exclude);

        $parsedHeaders = $headerParser->parse([
            'host' => 'localhost',
            'user-agent' => 'Symfony',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'accept-language' => 'en-us,en;q=0.5',
            'accept-charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'content-type' => 'application/x-www-form-urlencoded'
        ]);

        $expected1 = new HeaderSchema([
            'disabled' => false,
            'key' => 'content-type',
            'name' => 'content-type',
            'type' => 'text',
            'value' => 'application/x-www-form-urlencoded'
        ]);
        $expected2 = new HeaderSchema([
            'disabled' => false,
            'key' => 'content-type',
            'name' => 'content-type',
            'type' => 'text',
            'value' => 'application/x-www-form-urlencoded'
        ]);

        self::assertCount(2, $parsedHeaders);
        self::assertContains($expected1, $parsedHeaders, '', true, false);
        self::assertContains($expected2, $parsedHeaders, '', true, false);
    }
}
