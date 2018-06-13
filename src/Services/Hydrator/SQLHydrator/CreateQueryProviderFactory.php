<?php
namespace SqlDocumentor\Services\Hydrator\SQLHydrator;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CreateQueryProviderFactory
 * @package SqlDocumentor\Services\Hydrator\SQLHydrator
 */
class CreateQueryProviderFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return TableStructureProvider
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new TableStructureProvider($container->get('dbh'));
    }
}
