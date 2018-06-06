<?php
namespace SqlDocumentor;

use Pimple\Container;
//use SqlDocumentor\Services\Config;
use SqlDocumentor\Services\DbParser;
use SqlDocumentor\Services\TableParser;
use SqlDocumentor\Services\TemplateProcessor;
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
        /** @var DbParser $dbParser */
        $dbParser = $this->serviceManager->get(DbParser::class);

        /** @var TableParser $tableParser */
        $tableParser = $this->serviceManager->get(TableParser::class);

        /** @var TemplateProcessor $templateProcessor */
        $templateProcessor = $this->serviceManager->get(TemplateProcessor::class);

        $tables = [];

        foreach($dbParser->listTables() as $tableName) {
            $table = $tableParser->parseTable($tableName);

            $output = sprintf('%s%s.md', $this->config->path->target, $table->getName());

            $templateProcessor->processToFile(
                $this->config->path->templates . 'table.md.php',
                $output,
                ['table' => $table]
            );

            $tables[$table->getName()] = $table;
        }

        $templateProcessor->processToFile(
            $this->config->path->templates . 'index.md.php',
            $this->config->path->target . 'index.md',
            ['tables' => $tables]
        );
    }

    /**
     * @param string $message
     * @return $this
     */
    public function log(string $message)
    {
        printf($message . "\n");
        return $this;
    }
}
