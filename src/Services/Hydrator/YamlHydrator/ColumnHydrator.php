<?php
namespace SqlDocumentor\Services\Hydrator\YamlHydrator;

use SqlDocumentor\Model\Column;

/**
 * Class ColumnHydrator
 * @package SqlDocumentor\Services\Hydrator\YamlHydrator
 */
class ColumnHydrator
{
    const FIELD_COMMENT = 'comment';
    const FIELD_FLAGS = 'flags';

    /**
     * @param Column $column
     * @param array $yaml
     * @return Column
     */
    public function hydrate(Column $column, array $yaml): Column
    {
        if (isset($yaml[self::FIELD_COMMENT])) {
            $column->setComment($yaml[self::FIELD_COMMENT]);
        }
        if (isset($yaml[self::FIELD_FLAGS])) {
            foreach($yaml[self::FIELD_FLAGS] as $flag) {
                $column->addFlag(strtoupper($flag));
            }
        }
        return $column;
    }
}
