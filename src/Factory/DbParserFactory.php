<?php
namespace SqlDocumentor\Factory;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\DbParser;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DbParserFactory
 * @package SqlDocumentor\Factory
 */
class DbParserFactory
    implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return DbParser
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $parser = new DbParser();
        $parser->setDbh($container->get('dbh'));
        return $parser;
    }
}
