<?php
namespace SqlDocumentor\Factory;

use Interop\Container\ContainerInterface;
use Zend\Config\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DbConnectionFactory
 * @package SqlDocumentor\Factory
 */
class DbConnectionFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return \PDO
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Config $config */
        $config = $container->get('config')->get('database');

        return new \PDO(
            sprintf(
                'mysql:dbname=%s;host=%s',
                $config->get('database'),
                $config->get('host')
            ),
            $config->get('user'),
            $config->get('password')
        );
    }
}
