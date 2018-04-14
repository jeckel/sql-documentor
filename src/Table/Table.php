<?php

namespace SqlDocumentor\Table;

/**
 * Class Table
 * @package SqlDocumentor\Table
 */
class Table
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $createQuery;

    /** @var array  */
    protected $columns = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Table
     */
    public function setName(string $name): Table
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     * @return Table
     */
    public function setColumns(array $columns): Table
    {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
        return $this;
    }

    /**
     * @param Column $column
     * @return Table
     */
    public function addColumn(Column $column): Table
    {
        $this->columns[$column->getName()] = $column;
        return $this;
    }

    /**
     * @param $name
     * @return Column
     * @throws \Exception
     */
    public function getColumn($name): Column
    {
        if (! isset($this->columns[$name])) {
            throw new \Exception("Column $name not defined");
        }
        return $this->columns[$name];
    }

    /**
     * @return string
     */
    public function getCreateQuery(): string
    {
        return $this->createQuery;
    }

    /**
     * @param string $createQuery
     * @return Table
     */
    public function setCreateQuery(string $createQuery): Table
    {
        $this->createQuery = $createQuery;
        return $this;
    }
}
