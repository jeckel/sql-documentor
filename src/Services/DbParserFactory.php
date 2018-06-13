<?php
namespace SqlDocumentor\Services;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DbParserFactory
 * @package SqlDocumentor\Services
 */
class DbParserFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return DbParser
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DbParser(
            $container->get('dbh'),
            $container->get(TableBuilder::class)
        );
    }
}
