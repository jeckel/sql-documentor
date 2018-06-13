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

    /**
     * @return \PDO
     */
    public function getDbh(): \PDO
    {
        return $this->dbh;
    }

    /**
     * @param \PDO $dbh
     * @return DbParser
     */
    public function setDbh(\PDO $dbh): DbParser
    {
        $this->dbh = $dbh;
        return $this;
    }

    /**
     * @return array
     */
    public function listTables(): array
    {
        $tables = [];
        foreach ($this->dbh->query('SHOW TABLES') as $row) {
            $tables[] = $row[0];
        }
        return $tables;
    }

    /**
     * @param string $tableName
     * @return string
     */
    public function getCreateTable(string $tableName): string
    {
        return $this->dbh->query(
            sprintf('SHOW CREATE TABLE `%s`', $tableName)
        )->fetchColumn(1);
    }
}
