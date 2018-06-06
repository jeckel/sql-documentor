<?php
namespace SqlDocumentor\Factory;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\YamlParser;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class YamlParserFactory
 * @package SqlDocumentor\Factory
 */
class YamlParserFactory
    implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return YamlParser
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $parser = new YamlParser();
        $parser->setYmlDir($container->get('config')->path->yml);
        return $parser;
    }
}
