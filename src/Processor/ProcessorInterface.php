<?php
namespace SqlDocumentor\Processor;

use SqlDocumentor\Model\Table;

/**
 * Interface ProcessorInterface
 * @package SqlDocumentor\Processor
 */
interface ProcessorInterface
{
    /**
     * @param Table $table
     * @return Table
     */
    public function Process(Table $table): Table;
}
