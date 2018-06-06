<?php
namespace SqlDocumentor\Factory;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\CreateTableParser;
use SqlDocumentor\Services\DbParser;
use SqlDocumentor\Services\TableParser;
use SqlDocumentor\Services\YamlParser;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class TableParserFactory
 * @package SqlDocumentor\Factory
 */
class TableParserFactory
    implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $parser = new TableParser();
        $parser->setDbParser($container->get(DbParser::class))
            ->setCreateTableParser($container->get(CreateTableParser::class))
            ->setYmlParser($container->get(YamlParser::class));
        return $parser;
    }

}
