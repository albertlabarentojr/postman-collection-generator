This document describes the steps to install and use this package into a Lumen application.
- [Installation & Usage](#installation--usage)
- [PHP Annotations - Overriding options](#php-annotations---overriding-options)

# Installation & Usage
- [Require package in Composer](#require-package-in-composer)
- [Use the Trait](#use-the-trait)
- [Create Config file](#create-config-file)
## Require package in Composer

Require this package using [Composer][1]. 

```bash
composer require --dev anl/postman-collection-generator
```

## Use the Trait

Automatically generate postman  documentation from all api calls that uses `call` method in `Laravel\Lumen\Testing\TestCase` by just using `\PostmanGenerator\Bridge\Laravel\Lumen\Traits\GeneratePostmanApiCallTrait`.
```php
// tests/TestCase.php

use \PostmanGenerator\Bridge\Laravel\Lumen\Traits\GeneratePostmanApiCallTrait;
```

## Create Config file

Create `postman-generator.yaml` file with the following default contents:
```yaml
info:
  name: 'Project One'
  description: 'API documentation for Project One'
  file_name: 'ProjectOneCollection'
  base_url: '{{baseUrl}}'
options:

  # Include all usages of `call` method in Lumen Test Case in the api documentation.
  # If set to false, you can use annotations in your tests to include/exclude tests you want documented.
  auto_include: true
  
  # Define where you place your controllers so that the `Folder Name` in Postman will be properly guessed.
  controller_namespaces:
    - 'App\Http\Controllers'
  
  # Include or exclude http headers from request examples.
  http_headers:
    include:
      - 'accept'
      - 'authorization'
      - 'content-type'
    exclude:
  
  # If route calls point to an undefined route, skip and not throw exception.
  skip_undefined_route: true
```
---
That's it! All test calls to your api automatically generates a postman collection.

# PHP Annotations - Overriding options

## @PostmanInclude
If `auto_include` is set to false in the yaml config,
 you can specify which tests are to be generated with requests and examples.

For whole test class:
```php
// tests/Http/Controllers/Posts/CommentsControllerTest.php

/**
 ** @PostmanInclude
 */
class CommentsControllerTest extends \Laravel\Lumen\Testing\TestCase {
}
````
For specific tests:
```php
// tests/Http/Controllers/Posts/CommentsControllerTest.php

class CommentsControllerTest extends \Laravel\Lumen\Testing\TestCase {
    /**
     * @PostmanInclude
     */
    public function testAddCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',...);
    }
}
```
## @PostmanExclude

If you want to exclude tests you can use `@PostmanExclude` annotation in your tests just like `@PostmanInclude`.
For the whole test class if `auto_include` is set to true:
```php
// tests/Http/Controllers/Posts/CommentsControllerTest.php

/**
 ** @PostmanExclude
 */
class CommentsControllerTest extends \Laravel\Lumen\Testing\TestCase {
}
````
For specific tests:
```php
// tests/Http/Controllers/Posts/CommentsControllerTest.php

/**
 ** @PostmanInclude
 */
class CommentsControllerTest extends \Laravel\Lumen\Testing\TestCase {
    /**
     * @PostmanExclude
     */
    public function testAddCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',...);
    }
}
```

## @PostmanFolderName

By default, folder names are guessed based on controller name:

```
$controller = 'App\Http\Controllers\Posts\CommentsController';
$controllerNamespaces = ['App\Http\Controllers']; // set in yaml config.
$folderName = 'Posts.Comments'
```

If you want to override the calculated value, you can use `@PostmanFolderName` in your tests
```php
    /**
     * @PostmanFolderName Blog.Posts.Comments
     */
    public function testAddCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',...);
    }
```

## @PostmanRequestName

By default, request names are guessed based on route actions:
```
// in your routes.php
$router->get('comments','Posts\CommentsController@create');

// Request name will be
$requestName = 'Create Comment'
```

If you want to override the calculated value, you can use `@PostmanRequestName` in your tests
```php
    /**
     * @PostmanRequestName Add Comment
     */
    public function testCreateCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',...);
    }
```


## @PostmanExampleName

By default, example names are guessed based on test method name:
```php
    // In your test
    
    public function testCreateCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',...);
    }
```

Example name will be `Create Comment Successful`.

If you want to override the calculated value, you can use `@PostmanExampleName` in your tests
```php
    /**
     ** @PostmanExampleName Add comment to post successful
     */
    public function testCreateCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',...);
    }
```

## @PostmanDefaultRequest

By default, the last request call will be the one used for default requests. 
There will be problems if you have your expected request ran first. 

Example:
```php
    public function testCreateCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',[complete data]);
    }
    public function testCreateCommentValidationException(): void {
        // $this->json('POST','posts/post-id/comments',[empty data]);
    }
```
This will have you default request use `testCreateCommentValidationException` data.

To fix this you should use `@PostmanDefaultExample` in your test to use the correct request:

```php
    /**
     * @PostmanDefaultRequest
     */
    public function testCreateCommentSuccessful(): void {
        // $this->json('POST','posts/post-id/comments',[complete data]);
    }
    
    public function testCreateCommentValidationException(): void {
        // $this->json('POST','posts/post-id/comments',[empty data]);
    }
```

[1]: https://getcomposer.org/