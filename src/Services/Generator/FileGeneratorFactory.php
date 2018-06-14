<?php
namespace SqlDocumentor\Services\Generator;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class FileGeneratorFactory
 * @package SqlDocumentor\Services\Generator
 */
class FileGeneratorFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return FileGenerator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        return new FileGenerator(
            $container->get(TemplateParser::class),
            $config->get('path')->get('template'),
            $config->get('path')->get('target'),
            $config->get('path')->get('tableTemplate', FileGenerator::DEFAULT_TABLE_TEMPLATE),
            $config->get('path')->get('indexTemplate', FileGenerator::DEFAULT_INDEX_TEMPLATE)
        );
    }
}
