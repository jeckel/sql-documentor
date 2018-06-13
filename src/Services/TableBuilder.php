<?php
namespace SqlDocumentor\Services;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Model\TableFactory;
use SqlDocumentor\Services\Hydrator\SQLHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator;

/**
 * Class TableHydrator
 * @package SqlDocumentor\Services
 */
class TableBuilder
{
    /** @var YamlHydrator */
    protected $yamlHydrator;

    /** @var SQLHydrator */
    protected $sqlHydrator;

    /** @var TableFactory */
    protected $tableFactory;

    /**
     * TableBuilder constructor.
     * @param TableFactory $factory
     * @param SQLHydrator  $SQLHydrator
     * @param YamlHydrator $yamlHydrator
     */
    public function __construct(TableFactory $factory, SQLHydrator $SQLHydrator, YamlHydrator $yamlHydrator)
    {
        $this->tableFactory = $factory;
        $this->sqlHydrator = $SQLHydrator;
        $this->yamlHydrator = $yamlHydrator;
    }

    /**
     * @param string $tableName
     * @return Table
     */
    public function build(string $tableName): Table
    {
        return $this->yamlHydrator->hydrateTable(
            $this->sqlHydrator->hydrateTable(
                $this->tableFactory->factory(
                    $tableName
                )
            )
        );
    }
}
