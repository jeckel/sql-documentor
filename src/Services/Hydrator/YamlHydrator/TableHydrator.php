<?php
namespace SqlDocumentor\Services\Hydrator\YamlHydrator;

use SqlDocumentor\Model\Table;

/**
 * Class TableHydrator
 * @package SqlDocumentor\Services\Hydrator\YamlHydrator
 */
class TableHydrator
{
    /**
     * @param Table $table
     * @param array $yaml
     * @return Table
     */
    public function hydrate(Table $table, array $yaml): Table
    {
        if (! isset($yaml['table'])) {
            return $table;
        }
        if (isset($yaml['table']['desc'])) {
            $table->setDescription($yaml['table']['desc']);
        }
        if (isset($yaml['table']['short-desc'])) {
            $table->setShortDesc($yaml['table']['short-desc']);
        }

        return $table;
    }
}
