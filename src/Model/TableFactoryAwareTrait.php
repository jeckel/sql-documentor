<?php
namespace SqlDocumentor\Model;

/**
 * Trait TableFactoryAwareTrait
 * @package SqlDocumentor\Model
 */
trait TableFactoryAwareTrait
{
    /** @var TableFactory */
    protected $tableFactory;

    /**
     * @param TableFactory $factory
     * @return self
     */
    public function setTableFactory(TableFactory $factory)
    {
        $this->tableFactory = $factory;
        return $this;
    }

    /**
     * @return TableFactory
     */
    public function getTableFactory(): TableFactory
    {
        return $this->tableFactory;
    }
}
