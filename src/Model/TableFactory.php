<?php
namespace SqlDocumentor\Model;

/**
 * Class TableFactory
 * @package SqlDocumentor\Model
 */
class TableFactory
{
    /** @var array  */
    static protected $instances = [];

    /**
     * @param string $name
     * @return Table
     */
    public function factory(string $name): Table
    {
        if (! isset(self::$instances[$name])) {
            self::$instances[$name] = new Table($name);
        }
        return self::$instances[$name];
    }

    /**
     *
     */
    public static function reset(): void
    {
        self::$instances = [];
    }
}
