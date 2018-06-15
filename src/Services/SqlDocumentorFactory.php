<?php
namespace SqlDocumentor\Services;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\Generator\FileGenerator;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class SqlDocumentorFactory
 * @package SqlDocumentor\Services
 */
class SqlDocumentorFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return SqlDocumentor
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SqlDocumentor(
            $container->get(DbParser::class),
            $container->get(FileGenerator::class)
        );
    }
}
