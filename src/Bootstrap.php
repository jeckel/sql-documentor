<?php
namespace SqlDocumentor;

use Pimple\Container;
//use SqlDocumentor\Services\Config;
use SqlDocumentor\Table\Table;
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
        $this->serviceManager = new ServiceManager($this->config->get('service_manager'));
    }

//    /** @var Container */
//    protected $container;
//
//    /**
//     * Bootstrap constructor.
//     * @param array $bootstrap
//     */
//    public function __construct(array $bootstrap)
//    {
//        $this->container = new Container();
//        $this->container['config'] = new Config($bootstrap['config']);
//
//        foreach($bootstrap['services'] as $serviceName=>$builder) {
//            $this->container[$serviceName] = $builder;
//        }
//    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function connectToDatabase()
    {
        /** @var Config $config */
        $config = $this->container['config'];

        $this->container['dbh'] = new \PDO(
            sprintf(
                'mysql:dbname=%s;host=%s',
                $config->get('MYSQL_DATABASE'),
                $config->get('MYSQL_HOST')
            ),
            $config->get('MYSQL_USER'),
            $config->get('MYSQL_PASSWORD')
        );
        return $this;
    }

    /**
     * @return array
     */
    public function listTables()
    {
        /** @var \PDO $dbh */
        $dbh = $this->container['dbh'];
        $tables = [];
        foreach($dbh->query('SHOW TABLES') as $row) {
            $tables[] = $row[0];
        }
        return $tables;
    }

    /**
     * @param $tablename
     * @return mixed
     */
    public function getCreateTable($tablename)
    {
        /** @var \PDO $dbh */
        $dbh = $this->container['dbh'];
        $stmt = $dbh->query(sprintf('SHOW CREATE TABLE `%s`', $tablename));
        return $stmt->fetchColumn(1);
    }

    /**
     * @param string $create
     * @return Table
     * @throws \Exception
     */
    public function parse(string $create): Table
    {
        /** @var Config $config */
        $config = $this->container['config'];

        $table = $this->container['create-table-parser']->parse($create);
        $table = $this->container['yaml-parser']->parse($table);
        $generator = new TemplateGenerator($config->get('TARGET_DIRECTORY'));
        $generator->generate($table, __DIR__.'/Template/table.md.php');
        return $table;
    }

    /**
     * @throws \Exception
     */
    public function __invoke()
    {
        $this->connectToDatabase();

        $tables = [];

        foreach($this->listTables() as $tableName) {
            $table = $this->parse($this->getCreateTable($tableName));
            $tables[$table->getName()] = $table;
        }

        /** @var Config $config */
        $config = $this->container['config'];
        $generator = new TemplateGenerator($config->get('TARGET_DIRECTORY'));
        $generator->generateTpl(__DIR__.'/Template/index.md.php', 'index.md', ['tables' => $tables]);

        echo "done\n";
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
