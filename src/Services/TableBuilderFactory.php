<?php
namespace SqlDocumentor\Services;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Model\TableFactory;
use SqlDocumentor\Services\Hydrator\SQLHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class TableBuilderFactory
 * @package SqlDocumentor\Services
 */
class TableBuilderFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return TableBuilder
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new TableBuilder(
            $container->get(TableFactory::class),
            $container->get(SQLHydrator::class),
            $container->get(YamlHydrator::class)
        );
    }
}
