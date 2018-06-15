<?php
namespace SqlDocumentor\Services\Hydrator\YamlHydrator;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class FileParserFactory
 * @package SqlDocumentor\Services\Hydrator\YamlHydrator
 */
class FileParserFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return FileParser
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new FileParser(
            $container->get('config')->path->yml
        );
    }
}
