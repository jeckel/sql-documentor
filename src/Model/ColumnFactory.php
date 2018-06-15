<?php

namespace SqlDocumentor\Model;

/**
 * Class ColumnFactory
 * @package SqlDocumentor\Model
 */
class ColumnFactory
{
    /**
     * @param Table  $table
     * @param string $name
     * @return Column
     */
    public function factory(Table $table, string $name): Column
    {
        if ($table->hasColumn($name)) {
            return $table->getColumn($name);
        }
        $column = new Column($name);
        $table->addColumn($column);
        return $column;
    }
}
