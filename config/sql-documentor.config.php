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
        'template' => getenv('TEMPLATE_DIRECTORY')?:(PROJECT_ROOT.'tpl/'),
        'target'   => getenv('TARGET_DIRECTORY')?:(PROJECT_ROOT.'docs/'),
        'yml'      => getenv('YML_DIRECTORY')?:(PROJECT_ROOT.'yml/'),
    ],
    'service_manager' => [
        'factories' => [
            'dbh'                                                                      => \SqlDocumentor\Factory\DbConnectionFactory::class,
            'logger'                                                                   => \SqlDocumentor\Factory\LoggerFactory::class,
            \SqlDocumentor\Services\DbParser::class                                    => \SqlDocumentor\Services\DbParserFactory::class,
            \SqlDocumentor\Services\SqlDocumentor::class                               => \SqlDocumentor\Services\SqlDocumentorFactory::class,
            \SqlDocumentor\Services\TableBuilder::class                                => \SqlDocumentor\Services\TableBuilderFactory::class,
            \SqlDocumentor\Services\Generator\FileGenerator::class                     => \SqlDocumentor\Services\Generator\FileGeneratorFactory::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator::class                       => \SqlDocumentor\Services\Hydrator\YamlHydratorFactory::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator\FileParser::class            => \SqlDocumentor\Services\Hydrator\YamlHydrator\FileParserFactory::class,
            \SqlDocumentor\Services\Hydrator\SQLHydrator::class                        => \SqlDocumentor\Services\Hydrator\SQLHydratorFactory::class,
            \SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProvider::class => \SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProviderFactory::class,
        ],
        'invokables' => [
            \SqlDocumentor\Model\ColumnFactory::class                                  => \SqlDocumentor\Model\ColumnFactory::class,
            \SqlDocumentor\Model\TableFactory::class                                   => \SqlDocumentor\Model\TableFactory::class,
            \SqlDocumentor\Services\Hydrator\SQLHydrator\TableHydrator::class          => \SqlDocumentor\Services\Hydrator\SQLHydrator\TableHydrator::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator::class        => \SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator::class,
            \SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator::class         => \SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator::class,
            \SqlDocumentor\Services\Generator\TemplateParser::class                    => \SqlDocumentor\Services\Generator\TemplateParser::class,
        ],
        'initializers' => [
            \SqlDocumentor\Initializer\LoggerInitializer::class,
        ]
    ],
];
