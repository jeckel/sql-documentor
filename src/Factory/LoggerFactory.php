<?php
namespace SqlDocumentor\Factory;

use Interop\Container\ContainerInterface;
use Zend\Log\Logger;
use Zend\Log\PsrLoggerAdapter;
use Zend\Log\Writer\Stream;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LoggerFactory
 * @package SqlDocumentor\Factory
 */
class LoggerFactory
    implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return Logger
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $logger = new Logger();
        $logger->addWriter(new Stream('php://output'));
        return new PsrLoggerAdapter($logger);
    }
}
