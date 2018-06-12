<?php

namespace SqlDocumentor\Services\Hydrator;
use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator\FileParser;
use SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class YamlHydratorFactory
 * @package SqlDocumentor\Services\Hydrator
 */
class YamlHydratorFactory
    implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return YamlHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new YamlHydrator(
            $container->get(FileParser::class),
            $container->get(TableHydrator::class),
            $container->get(ColumnHydrator::class)
        );
    }
}
