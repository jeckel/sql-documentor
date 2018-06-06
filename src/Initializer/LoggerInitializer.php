<?php

namespace SqlDocumentor\Initializer;
use Interop\Container\ContainerInterface;
use Psr\Log\LoggerAwareInterface;
use Zend\ServiceManager\Initializer\InitializerInterface;

/**
 * Class LoggerInitializer
 * @package SqlDocumentor\Initializer
 */
class LoggerInitializer
    implements InitializerInterface
{
    /**
     * Initialize the given instance
     *
     * @param  ContainerInterface $container
     * @param  object $instance
     * @return void
     */
    public function __invoke(ContainerInterface $container, $instance)
    {
        if ($instance instanceof LoggerAwareInterface) {
            $instance->setLogger($container->get('logger'));
        }
    }
}
