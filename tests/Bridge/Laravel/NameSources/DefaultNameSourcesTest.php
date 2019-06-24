<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Bridge\Laravel\NameSources;

use PostmanGenerator\Bridge\Laravel\Lumen\Data\DefaultNamesSource;
use PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Bridge\Laravel\Lumen\Data\DefaultNamesSource
 */
final class DefaultNameSourcesTest extends TestCase
{
    public function testFunctionCallerTraceReturnedEmptyAndDefaultsToMethodName(): void
    {
        $baseNamespace = ['App\\My\\Own\\Namespace'];
        $controller = 'App\\My\\Own\\Namespace\\MyVeryOwn\\ResourceController';
        $method = 'Get Names';

        $source = new DefaultNamesSource(new RouteAction($controller, $method), 'testGetNames', $baseNamespace);

        self::assertEquals('MyVeryOwn.Resource', $source->getFolderName());
        self::assertEquals('Get Names', $source->getRequestName());
        self::assertEquals('Get Names', $source->getExampleName());
    }

    public function testGetNamesOnInvokableController(): void
    {
        $baseNamespace = ['App\\My\\Own\\Namespace'];
        $controller = 'App\\My\\Own\\Namespace\\MyVeryOwn\\PublishPost';
        $method = '__invoke';

        $source = new DefaultNamesSource(
            new RouteAction($controller, $method),
            'testPostPublishedSuccess',
            $baseNamespace
        );

        self::assertEquals('MyVeryOwn.PublishPost', $source->getFolderName());
        self::assertEquals('Publish Post', $source->getRequestName());
        self::assertEquals('Post Published Success', $source->getExampleName());
    }

    public function testGetNamesShouldRemoveControllerMethodFromExampleName(): void
    {
        $baseNamespace = ['App\\My\\Own\\Namespace'];
        $controller = 'App\\My\\Own\\Namespace\\MyVeryOwn\\ResourceController';
        $method = 'Get Names';
        $testMethod = 'testGetNamesShouldRemoveControllerMethodFromExampleName';

        $source = new DefaultNamesSource(new RouteAction($controller, $method), $testMethod, $baseNamespace);

        self::assertEquals('MyVeryOwn.Resource', $source->getFolderName());
        self::assertEquals('Get Names', $source->getRequestName());
        self::assertEquals('Should Remove Controller Method From Example Name', $source->getExampleName());
    }

    public function testGetNamesShouldReturnThisAsExampleName(): void
    {
        $baseNamespace = ['App\\My\\Own\\Namespace'];
        $controller = 'App\\My\\Own\\Namespace\\MyVeryOwn\\ResourcesController';
        $method = 'publish';
        $testMethod = 'testGetNamesShouldReturnThisAsExampleName';

        $source = new DefaultNamesSource(new RouteAction($controller, $method), $testMethod, $baseNamespace);

        self::assertEquals('MyVeryOwn.Resources', $source->getFolderName());
        // Assumes controller name is a resource
        self::assertEquals('Publish Resource', $source->getRequestName());
        self::assertEquals('Get Names Should Return This As Example Name', $source->getExampleName());
    }
}
