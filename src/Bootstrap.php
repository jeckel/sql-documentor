<?php
namespace SqlDocumentor;

use SqlDocumentor\Services\SqlDocumentor;
use Zend\Config\Config;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Bootstrap
 * @package SqlDocumentor
 */
class Bootstrap
{
    /** @var ServiceManager */
    protected $serviceManager;

    /** @var Config */
    protected $config;

    /**
     * Bootstrap constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
        $this->serviceManager = new ServiceManager($this->config->get('service_manager')->toArray());
        $this->serviceManager->setService('config', $this->config);
    }

    /**
     * @throws \Exception
     */
    public function __invoke()
    {
        $this->serviceManager->get(SqlDocumentor::class)->generate();
    }
}
