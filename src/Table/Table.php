<?php

namespace SqlDocumentor\Table;

/**
 * Class Table
 * @package SqlDocumentor\Table
 */
class Table
{
    /** @var string */
    protected $name = '';

    /** @var string */
    protected $description = '';

    /** @var string */
    protected $shortDesc = '';

    /** @var string */
    protected $createQuery = '';

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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Table
     */
    public function setDescription(string $description): Table
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDesc(): string
    {
        if (! empty($this->shortDesc)) {
            return $this->shortDesc;
        }
        // if no short desc, return first line of long desc
        return empty($this->description)?'':strtok($this->description, "\n");
    }

    /**
     * @param string $shortDesc
     * @return Table
     */
    public function setShortDesc(string $shortDesc): Table
    {
        $this->shortDesc = $shortDesc;
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
    public function getColumn(string $name): Column
    {
        if (! isset($this->columns[$name])) {
            throw new \Exception("Column $name not defined");
        }
        return $this->columns[$name];
    }

    public function hasColumn(string $name): bool
    {
        return isset($this->columns[$name]);
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
