<?php
namespace SqlDocumentor\Model;

/**
 * Class TableFactory
 * @package SqlDocumentor\Model
 */
class TableFactory
{
    /** @var array */
    protected $instances = [];

    /**
     * @param string $tableName
     * @return Table
     */
    public function factory(string $tableName)
    {
        if (! isset($this->instances[$tableName])) {
            $this->instances[$tableName] = new Table($tableName);
        }
        return $this->instances[$tableName];
    }
}
