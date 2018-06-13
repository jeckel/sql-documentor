<?php
define('PROJECT_ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);

return [
    'database' => [
        'host'     => getenv('MYSQL_HOST')?:'localhost',
        'database' => getenv('MYSQL_DATABASE'),
        'user'     => getenv('MYSQL_USER')?:'root',
        'password' => getenv('MYSQL_PASSWORD')?:'',
    ],
    'path' => [
        'templates' => getenv('TEMPLATE_DIRECTORY')?:(PROJECT_ROOT.'tpl/'),
        'target'    => getenv('TARGET_DIRECTORY')?:(PROJECT_ROOT.'docs/'),
        'yml'       => getenv('YML_DIRECTORY')?:(PROJECT_ROOT.'yml/'),
    ],
    'service_manager' => [
        'factories' => [
            'dbh'                                            => \SqlDocumentor\Factory\DbConnectionFactory::class,
            'logger'                                         => \SqlDocumentor\Factory\LoggerFactory::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator\FileParser::class         => \SqlDocumentor\Services\Hydrator\YamlHydrator\FileParserFactory::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator::class                    => \SqlDocumentor\Services\Hydrator\YamlHydratorFactory::class,
            \SqlDocumentor\Services\Hydrator\SQLHydrator\CreateQueryProvider::class => \SqlDocumentor\Services\Hydrator\SQLHydrator\CreateQueryProviderFactory::class,
            \SqlDocumentor\Services\CreateTableParser::class => \SqlDocumentor\Factory\CreateTableParserFactory::class,
            \SqlDocumentor\Services\DbParser::class          => \SqlDocumentor\Factory\DbParserFactory::class,
        ],
        'invokables' => [
            \PHPSQLParser\PHPSQLParser::class                => \PHPSQLParser\PHPSQLParser::class,
            \SqlDocumentor\Services\TemplateProcessor::class => \SqlDocumentor\Services\TemplateProcessor::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator::class     => \SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator::class      => \SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator::class
        ],
        'initializers' => [
            \SqlDocumentor\Initializer\LoggerInitializer::class,
        ]
    ],
];
