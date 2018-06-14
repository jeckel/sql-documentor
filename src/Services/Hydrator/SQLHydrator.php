<?php
namespace SqlDocumentor\Services\Hydrator;

use SqlDocumentor\Model\ColumnFactory;
use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableHydrator;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProvider;

/**
 * Class SQLHydrator
 * @package SqlDocumentor\Services\Hydrator
 */
class SQLHydrator implements HydratorInterface
{
    /** @var TableStructureProvider */
    protected $structureProvider;

    /** @var TableHydrator */
    protected $tableHydrator;

    /** @var ColumnFactory */
    protected $columnFactory;

    /**
     * SQLHydrator constructor.
     * @param TableStructureProvider $createQuery
     * @param TableHydrator          $tableHydrator
     * @param ColumnFactory          $columnFactory
     */
    public function __construct(
        TableStructureProvider $createQuery,
        TableHydrator $tableHydrator,
        ColumnFactory $columnFactory
    ) {
        $this->structureProvider = $createQuery;
        $this->tableHydrator = $tableHydrator;
        $this->columnFactory = $columnFactory;
    }

    /**
     * @return TableStructureProvider
     */
    public function getStructureProvider(): TableStructureProvider
    {
        return $this->structureProvider;
    }

    /**
     * @return TableHydrator
     */
    public function getTableHydrator(): TableHydrator
    {
        return $this->tableHydrator;
    }

    /**
     * @return ColumnFactory
     */
    public function getColumnFactory(): ColumnFactory
    {
        return $this->columnFactory;
    }

    /**
     * @param Table $table
     * @return Table
     */
    public function hydrateTable(Table $table): Table
    {
        $query = $this->structureProvider->getCreateTable($table->getName());
        $table->setCreateQuery($query);

        $structure = $this->structureProvider->getStructure($query);

        $this->tableHydrator->hydrateTableMeta($table, $structure['table']);
        foreach ($structure['columns'] as $name => $params) {
            $this->tableHydrator->hydrateColumn(
                $this->columnFactory->factory($table, $name),
                $params
            );
        }

        $this->hydrateTableMeta($table, $structure['table']);

        return $table;
    }

    /**
     * @param Table $table
     * @param array $meta
     * @return SQLHydrator
     */
    protected function hydrateTableMeta(Table $table, array $meta): self
    {
        $table->setEngine($meta['engine'])
            ->setCharset($meta['charset'])
            ->setDescription($meta['comment']);
        return $this;
    }
}
