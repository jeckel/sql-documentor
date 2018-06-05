<?php
namespace SqlDocumentor\Services;

/**
 * Class Config
 * @package SqlDocumentor
 */
class Config
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * Config constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string $param
     * @return mixed
     * @throws \Exception
     */
    public function get(string $param)
    {
        if (! isset($config[$param])) {
            if (($env = getenv($param)) !== false) {
                $this->config[$param] = $env;
            } else {
                throw new \Exception('Undefined config value '.$param);
            }
        }
        return $this->config[$param];
    }
}
