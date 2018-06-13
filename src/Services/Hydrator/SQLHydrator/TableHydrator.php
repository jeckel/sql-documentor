<?php
namespace SqlDocumentor\Services\Hydrator\SQLHydrator;

use SqlDocumentor\Model\Table;

/**
 * Class TableHydrator
 * @package SqlDocumentor\Services\Hydrator\SQLHydrator
 */
class TableHydrator
{
    /**
     * @param Table $table
     * @param array $meta
     * @return Table
     */
    public function hydrateTableMeta(Table $table, array $meta): Table
    {
        if (!empty($meta['engine'])) {
            $table->setEngine($meta['engine']);
        }

        if (!empty($meta['charset'])) {
            $table->setCharset($meta['charset']);
        }

        if (!empty($meta['comment'])) {
            $table->setDescription($meta['comment']);
        }

        return $table;
    }
}
