<?php
namespace SqlDocumentor;

use PHPSQLParser\PHPSQLParser;
use Pimple\Container;
use SqlDocumentor\Markdown\Markdown;
use SqlDocumentor\Services\CreateTableParser;
use SqlDocumentor\Services\YamlParser;

/**
 * Class Bootstrap
 * @package SqlDocumentor
 */
class Bootstrap
{
    /** @var Container */
    protected $container;

    /**
     * @return $this
     */
    public function initContainer()
    {
        $this->container = new Container();
        $this->container['config'] = new Config();
        $this->container['sql-parser'] = function() { return new PHPSQLParser(); };
        $this->container['markdown-helper'] = function() { return new Markdown(); };
        $this->container['yaml-parser'] = function($c) {
            return new YamlParser($c['config']->get('YML_DIRECTORY'));
        };
        $this->container['create-table-parser'] = function($c) {
            return new CreateTableParser($c['sql-parser']);
        };
        return $this;
    }

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

    public function getCreateTable($tablename)
    {
        /** @var \PDO $dbh */
        $dbh = $this->container['dbh'];
        $stmt = $dbh->query(sprintf('SHOW CREATE TABLE `%s`', $tablename));
        return $stmt->fetchColumn(1);
    }

    public function parse($create)
    {
        /** @var Config $config */
        $config = $this->container['config'];

        $table = $this->container['create-table-parser']->parse($create);
        $table = $this->container['yaml-parser']->parse($table);
        $generator = new TemplateGenerator($config->get('TARGET_DIRECTORY'));
        $generator->generate($table, __DIR__.'/Template/table.md.php');
/*        $generator = new MarkdownGenerator($config->get('TARGET_DIRECTORY'));
        $document = $generator->generate($table);
        $document->export();
        $this->log($document->getOutput());
*/    }

    /**
     * @throws \Exception
     */
    public function __invoke() {
        $this->initContainer()
            ->connectToDatabase();

        foreach($this->listTables() as $tableName) {
            $this->parse($this->getCreateTable($tableName));
            break;
        }

        echo "done\n";
    }

    public function log(string $message)
    {
        printf($message . "\n");
        return $this;
    }
}
