<?php
namespace SqlDocumentor\Services\Generator;

use SqlDocumentor\Model\Table;

/**
 * Interface GeneratorInterface
 * @package SqlDocumentor\Services\Generator
 */
interface GeneratorInterface
{
    /**
     * @param Table $table
     * @return string
     */
    public function generateTable(Table $table): string;

    /**
     * @param array $tables
     * @return string
     */
    public function generateIndex(array $tables): string;
}
