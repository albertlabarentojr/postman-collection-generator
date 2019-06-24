### Powered by [Postman Collection](https://www.getpostman.com/collection)

![Drag Racing](postman-logo.svg)

## Installation
```
composer require anl/postman-collection-generator
```

## Lumen
[Installation and Usage](docs/lumen.md)

## About

You might want to document your api, but wait!... setting up postman collection
with your environment?
Sure that's great but for developers who are not fond of doing this manually,
Integrate **Postman Collection Generator** in your functional tests.
Code while making your api well documented.

## Postman Schema version
Package currently supports https://schema.getpostman.com/json/collection/v2.0.0/docs/index.html

### Sample Output
#### Collection
![Drag Racing](collection.png)

#### Collection Request and Example Response
![Drag Racing](example.png)
![Drag Racing](example-2.png)


## Schema Structure
- CollectionSchema **PokemonApi**
    - CollectionItemSchema **PokemonTrainer**
        - CollectionSubItemSchema ```TrainerLaboratory```
            - ItemSchema ```Create Trainer Laboratory```
        - ItemSchema ```Create Trainer```
            - RequestSchema
            - ResponseSchema[]
                - [0] ```Create Trainer Successful```
                - [1] ```Create Trainer Not Found```
                
## Upcoming Releases
### v2.0.0
- PostmanGenerator a new Generation. 
- We aim to lessen the code when documenting, how about a feature to automatically suggest
the Example Name, Request Name and Sub-folders Name to your collection?

### v2.1.0
- Will be adding Postman Lumen TestCase to override ```call(...)``` method
Using the PostmanApiCallTrait we only get the instance of collection generator from the container.

### v2.2.0
- A reliable Api needs to detect semantic changes automatically for you.

## Latest Release
### v1.3.0
- This comes with the backwards-compatible manner of adding Lumen support 
for generating documentation.
                
## Releases
### v1.2.2
- Added PostmanGenerator helper [PostmanApiCallTrait](https://github.com/AlbertLabarento/postman-collection-generator/blob/master/src/Traits/PostmanApiCallTrait.php)
### v1.2.1
- Resolved Issue #3
- Added caching mechanism for generated collection.
- Added Persistence mechanism thanks to [Nathan Page](https://github.com/natepage)
### v1.1.1
- Updated documentation.
### v1.0
- Be able to modify existing collection.
