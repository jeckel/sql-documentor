<?php
namespace SqlDocumentor\Model;

/**
 * Interface ColumnFactoryAwareTrait
 * @package SqlDocumentor\Model
 */
trait ColumnFactoryAwareTrait
{
    /** @var ColumnFactory */
    protected $columnFactory;

    /**
     * @param ColumnFactory $columnFactory
     * @return mixed
     */
    public function setColumnFactory(ColumnFactory $columnFactory)
    {
        $this->columnFactory = $columnFactory;
        return $this;
    }

    /**
     * @return ColumnFactory
     */
    public function getColumnFactory()
    {
        return $this->columnFactory;
    }
}
