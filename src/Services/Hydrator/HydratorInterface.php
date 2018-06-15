<?php
namespace SqlDocumentor\Services\Hydrator;

use SqlDocumentor\Model\Table;

/**
 * Interface HydratorInterface
 * @package SqlDocumentor\Services\Hydrator
 */
interface HydratorInterface
{
    /**
     * @param Table $table
     * @return Table
     */
    public function hydrateTable(Table $table): Table;
}
