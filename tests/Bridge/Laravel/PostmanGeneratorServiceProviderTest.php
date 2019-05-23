<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Bridge\Laravel;

use PostmanGenerator\Bridge\Laravel\PostmanGeneratorServiceProvider;
use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Interfaces\GeneratorInterface;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Bridge\Laravel\PostmanGeneratorServiceProvider
 */
final class PostmanGeneratorServiceProviderTest extends TestCase
{
    /**
     * Test generated should be registered.
     *
     * @return void
     */
    public function testRegister(): void
    {
        /** @var \Illuminate\Contracts\Foundation\Application $app */
        $app = $this->getApplication();
        $provider = new PostmanGeneratorServiceProvider($app);

        $provider->boot();
        $provider->register();

        $this->assertServiceInstanceOf(GeneratorInterface::class, CollectionGenerator::class);
    }
}
