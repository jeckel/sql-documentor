<?php

namespace SqlDocumentor\Model;

/**
 * Class ColumnFactory
 * @package SqlDocumentor\Model
 */
class ColumnFactory
{
    /** @var array */
    protected $instances = [];

    /**
     * @param string $columnName
     * @return Column
     */
    public function factory(string $columnName)
    {
        if (! isset($this->instances[$columnName])) {
            $this->instances[$columnName] = new Column($columnName);
        }
        return $this->instances[$columnName];
    }
}
