<?php
/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 05/06/18
 * Time: 23:27
 */

$dflConfig = [
    'YML_DIRECTORY' => realpath(__DIR__ . '/../docs/yml')
];

return [
    'config' => array_merge($dflConfig, getenv()),
    'service_manager' => [
        'factories' => [
            \SqlDocumentor\Services\YamlParser::class        => \SqlDocumentor\Factory\YamlParserFactory::class,
            \SqlDocumentor\Services\CreateTableParser::class => \SqlDocumentor\Factory\CreateTableParserFactory::class
        ],
        'invokables' => [
            \PHPSQLParser\PHPSQLParser::class                => \PHPSQLParser\PHPSQLParser::class
        ]
    ],
];
