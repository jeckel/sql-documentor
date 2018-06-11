<?php

namespace SqlDocumentor\Services;
use SqlDocumentor\Model\Table;
use SqlDocumentor\Model\TableFactoryAwareInterface;
use SqlDocumentor\Model\TableFactoryAwareTrait;

/**
 * Class TableParser
 * @package SqlDocumentor\Services
 */
class TableParser
    implements TableFactoryAwareInterface
{
    use TableFactoryAwareTrait;

    /** @var YamlParser */
    protected $ymlParser;

    /** @var DbParser */
    protected $dbParser;

    /** @var CreateTableParser */
    protected $createTableParser;

    /**
     * @return YamlParser
     */
    public function getYmlParser(): YamlParser
    {
        return $this->ymlParser;
    }

    /**
     * @param YamlParser $ymlParser
     * @return TableParser
     */
    public function setYmlParser(YamlParser $ymlParser): TableParser
    {
        $this->ymlParser = $ymlParser;
        return $this;
    }

    /**
     * @return DbParser
     */
    public function getDbParser(): DbParser
    {
        return $this->dbParser;
    }

    /**
     * @param DbParser $dbParser
     * @return TableParser
     */
    public function setDbParser(DbParser $dbParser): TableParser
    {
        $this->dbParser = $dbParser;
        return $this;
    }

    /**
     * @return CreateTableParser
     */
    public function getCreateTableParser(): CreateTableParser
    {
        return $this->createTableParser;
    }

    /**
     * @param CreateTableParser $createTableParser
     * @return TableParser
     */
    public function setCreateTableParser(CreateTableParser $createTableParser): TableParser
    {
        $this->createTableParser = $createTableParser;
        return $this;
    }


    /**
     * @param string $tableName
     * @return Table
     */
    public function parseTable(string $tableName): Table
    {
        $table = $this->tableFactory->factory($tableName);

        $createQuery = $this->dbParser->getCreateTable($tableName);
//        $table = new Table();
        $table->setCreateQuery($createQuery);

        $this->createTableParser->parseTable($table, $createQuery);
        $this->ymlParser->parse($table);

        return $table;
    }
}
