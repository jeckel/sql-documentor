<?php
namespace SqlDocumentor\Processor;

use SqlDocumentor\Model\Table;

/**
 * Class DbProcessor
 * @package SqlDocumentor\Processor
 */
class DbProcessor
    implements ProcessorInterface
{
    /**
     * @param Table $table
     * @return Table
     */
    public function Process(Table $table): Table
    {
        // TODO: Implement Process() method.
        return $table;
    }
}
