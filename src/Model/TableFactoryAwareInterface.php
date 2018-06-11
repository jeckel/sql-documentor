<?php
namespace SqlDocumentor\Model;

/**
 * Interface TableFactoryAwareInterface
 * @package SqlDocumentor\Model
 */
interface TableFactoryAwareInterface
{
    /**
     * @param TableFactory $factory
     * @return mixed
     */
    public function setTableFactory(TableFactory $factory);
}
