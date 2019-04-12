<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator;

use Closure;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase as PhpunitTestCase;

abstract class TestCase extends PhpunitTestCase
{
    /**
     * Create mock with callback.
     *
     * @param string $mockClass
     * @param \Closure|null $callback
     *
     * @return \Mockery\MockInterface
     */
    public function mock(string $mockClass, ?Closure $callback = null): MockInterface
    {
        $mock = Mockery::mock($mockClass);

        if ($callback !== null) {
            $callback($mock);
        }

        return $mock;
    }

    /**
     * Assert given file contains expected collection content.
     *
     * @param string $file
     * @param array $expected
     *
     * @return void
     */
    protected function assertGeneratedCollection(string $file, array $expected): void
    {
        self::assertEquals(\json_decode(\file_get_contents($file), true), $expected);
    }
}
