## About

You might want to document your api, but wait!... setting up postman collection 
with your environment? 
Sure that's great but for developers who are not fun of doing this manually, 
Integrate **Postman Collection Generator** in your functional tests. 
Code while making your api well documented. 

## Postman Schema version
Package currently supports https://schema.getpostman.com/json/collection/v2.0.0/docs/index.html

### Usage
#### Configure your collection.

Using phpunit may require you to understand its life cycle to instantiate objects dynamically.
**PHPUNIT** **setUpBeforeClass()**

Create your collection. 
See https://learning.getpostman.com/docs/postman/collections/creating_collections/#how-to-create-collections
```php
$collectionObject = new CollectionObject([
     info' => new InfoObject([
        'description' => 'PokemonApi',
        'name' => 'Gotta catch them all. When you are a dev but loves pokemon.',
        'schema' => 'https://schema.getpostman.com/json/collection/v2.0.0/docs/index.html'
    ])
]);
```


```php
// Configure your postman generator.
$postmanConfig =  new ConfigObject();
$postmanConfig->setExportDirectory(
    __DIR__ . '/../../postman-collection.json'
);

// You may override your existing collection, just in case an existing collection already exists.
$postmanConfig->setOverrideExisting(true); 

// Set your api generator globaly to be accessible to your test classes.
self::$apiGenerator = new CollectionGenerator(
    $collectionObject, 
    new Serializer(), 
    $postmanConfig
);
```



#### Saving a request to a collection.
See. https://learning.getpostman.com/docs/postman/collections/creating_collections/#saving-a-request-to-a-collection
**PHPUNIT** **setUpBeforeClass()**
```php
self::$pokemonTrainerCollection = self::$apiGenerator->add('Pokemon Trainer');

self::$pokemonTrainerCollection['createTrainer'] = self::$pokemonTrainerCollection->addRequest(
    'Create Trainer',
    new RequestParser('POST', '{{baseUrl}}/v1/trainers', [])
);
```

#### Adding examples to your request.
See https://learning.getpostman.com/docs/postman/collections/examples/
```php
$this->addRequestExample(
    self::$pokemonTrainerCollection['createTrainer'],
    'Validation Failed',
    'POST',
    '/v1/trainers',
    [] // empty payload will throw validation error.
);
```
You may want to create a method to add request example.
```php
/** @var string[]  */
protected static $statusCodeText = [
    404 => 'Not Found',
    200 => 'Ok',
    500 => 'Server Error',
    204 => 'No Content',
    201 => 'Created',
    409 => 'Conflict',
    400 => 'Bad Request',
    403 => 'Forbidden',
    401 => 'Unauthorized',
    422 => 'Unprocessable Entity',
    203 => 'Non-Authoritative'
];

/**
 * Add request example.
 *
 * @param \PostmanGenerator\RequestExample $requestExample
 * @param string $exampleName
 * @param string $method
 * @param string $url
 * @param mixed[] $body
 * @param null|mixed[] $headers
 *
 * @return \PostmanGenerator\Interfaces\RequestExampleInterface
 */
protected function addRequestExample(
    RequestExample $requestExample,
    string $exampleName,
    string $method,
    string $url,
    array $body,
    ?array $headers = null
): RequestExampleInterface {
    return $requestExample->addExample(
        $exampleName,
        new RequestParser($method, '{{baseUrl}}/' . $url, $body, $headers),
        new ResponseParser($this->response, self::$statusCodeText[$this->response->getStatusCode()])
    );
}
```

#### Then after each tests classes that was executed, generate a postman collection.
```php
/**
 * Generate postman collection.
 *
 * @throws \PostmanGenerator\Exceptions\MissingConfigurationKeyException
 */
public static function tearDownAfterClass()
{
    parent::tearDownAfterClass();

    self::$apiGenerator->generate();
}
```

## Releases
### master - v1.0
- Be able to modify existing collection.

