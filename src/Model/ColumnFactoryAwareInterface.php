<?php
namespace SqlDocumentor\Model;

/**
 * Interface ColumnFactoryAwareInterface
 * @package SqlDocumentor\Model
 */
interface ColumnFactoryAwareInterface
{
    /**
     * @param ColumnFactory $columnFactory
     * @return mixed
     */
    public function setColumnFactory(ColumnFactory $columnFactory);
}
