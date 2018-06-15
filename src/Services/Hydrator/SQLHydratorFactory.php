<?php
namespace SqlDocumentor\Services\Hydrator;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Model\ColumnFactory;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableHydrator;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProvider;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class SQLHydratorFactory
 * @package SqlDocumentor\Services\Hydrator
 */
class SQLHydratorFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return SQLHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SQLHydrator(
            $container->get(TableStructureProvider::class),
            $container->get(TableHydrator::class),
            $container->get(ColumnFactory::class)
        );
    }
}
