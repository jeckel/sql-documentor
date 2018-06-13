<?php
namespace SqlDocumentor\Factory;

use Interop\Container\ContainerInterface;
use PHPSQLParser\PHPSQLParser;
use SqlDocumentor\Services\CreateTableParser;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CreateTableParserFactory
 * @package SqlDocumentor\Factory
 */
class CreateTableParserFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return CreateTableParser
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $parser = new CreateTableParser();
        $parser->setSqlParser($container->get(PHPSQLParser::class));
        return $parser;
    }
}
