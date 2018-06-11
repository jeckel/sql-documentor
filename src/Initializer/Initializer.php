<?php

namespace SqlDocumentor\Initializer;
use Interop\Container\ContainerInterface;
use SqlDocumentor\Model\ColumnFactory;
use SqlDocumentor\Model\ColumnFactoryAwareInterface;
use SqlDocumentor\Model\TableFactory;
use SqlDocumentor\Model\TableFactoryAwareInterface;
use Zend\ServiceManager\Initializer\InitializerInterface;

/**
 * Class Initializer
 * @package SqlDocumentor\Initializer
 */
class Initializer
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
        if ($instance instanceof TableFactoryAwareInterface) {
            $instance->setTableFactory($container->get(TableFactory::class));
        }

        if ($instance instanceof ColumnFactoryAwareInterface) {
            $instance->setColumnFactory($container->get(ColumnFactory::class));
        }
    }
}
