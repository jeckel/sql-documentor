<?php
namespace SqlDocumentor\Services;

/**
 * Class DbParser
 * @package SqlDocumentor\Services
 */
class DbParser
{
    /** @var \PDO */
    protected $dbh;

    /** @var TableBuilder */
    protected $tableBuilder;

    /**
     * DbParser constructor.
     * @param \PDO         $dbh
     * @param TableBuilder $tableBuilder
     */
    public function __construct(\PDO $dbh, TableBuilder $tableBuilder)
    {
        $this->dbh = $dbh;
        $this->tableBuilder = $tableBuilder;
    }

    /**
     * @return \PDO
     */
    public function getDbh(): \PDO
    {
        return $this->dbh;
    }

    /**
     * @return TableBuilder
     */
    public function getTableBuilder(): TableBuilder
    {
        return $this->tableBuilder;
    }

    /**
     * @return array
     */
    public function parseDb()
    {
        $tables = [];
        foreach ($this->dbh->query('SHOW TABLES') as $row) {
            $table = $this->tableBuilder->build($row[0]);
            $tables[$table->getName()] = $table;
        }
        return $tables;
    }
}
