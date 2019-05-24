<?php
declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Schema Generator configurations.
    |--------------------------------------------------------------------------
    |
    | Here you will define the ff.
    |   - name (Name of you collection)
    |   - description (Collection description)
    |   - export_directory (File directory when exported)
    |   - file_name (Collection file name)
    |   - base_url (Base Application url)
    */
    'schema' => [],

    /*
    |--------------------------------------------------------------------------
    | Route List Custom Folder Names.
    |--------------------------------------------------------------------------
    |
    | Here you will define all custom folders you want to override since Postman Generator
    | will automatically generate names for your folder, request and examples.
    | Given by a request test case:
    |   URL - trainers/{{trainerId}}/pokemons
    |   HTTP Method - GET
    |   Response Code - 200
    | Given by you test cases:
    | A collection naming will looks like
    |   Folder - Trainers
    |       Folder - Pokemons
    |           Request - Pokemons
    |               Example - Successful
    |
    | Hence you may wish to override this by.
    | 'GET /trainers/{{trainerId}}/pokemons' => [
    |        [
    |            'status_code' => 200, // required
    |            'fragments => [
    |                   'trainers' => 'Trainers Requests', // override folder name
    |                   'pokemons' => 'List of Pokemons' // override request name
    |            ]
    |        ]
    |    ],
    */
    'routes' => []
];
