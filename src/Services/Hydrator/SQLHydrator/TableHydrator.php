<?php
namespace SqlDocumentor\Services\Hydrator\SQLHydrator;

use SqlDocumentor\Model\Column;
use SqlDocumentor\Model\Table;

/**
 * Class TableHydrator
 * @package SqlDocumentor\Services\Hydrator\SQLHydrator
 */
class TableHydrator
{
    /**
     * @param Table $table
     * @param array $data
     * @return Table
     */
    public function hydrateTableMeta(Table $table, array $data): Table
    {
        if (!empty($data['engine'])) {
            $table->setEngine($data['engine']);
        }

        if (!empty($data['charset'])) {
            $table->setCharset($data['charset']);
        }

        if (!empty($data['comment'])) {
            $table->setDescription($data['comment']);
        }

        return $table;
    }

    /**
     * @param Column $column
     * @param array  $data
     * @return Column
     */
    public function hydrateColumn(Column $column, array $data): Column
    {
        $column->setType($data['type'])
            ->setNullable($data['null'])
            ->setAutoIncrement(
                isset($data['auto-increment']) && $data['auto-increment'] === true
            );

        if (!empty($data['comment'])) {
            $column->setComment($data['comment']);
        }
        return $column;
    }
}
