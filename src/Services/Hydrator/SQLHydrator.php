<?php
namespace SqlDocumentor\Services\Hydrator;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProvider;

/**
 * Class SQLHydrator
 * @package SqlDocumentor\Services\Hydrator
 */
class SQLHydrator implements HydratorInterface
{
    /** @var TableStructureProvider */
    protected $structureProvider;

    /**
     * SQLHydrator constructor.
     * @param TableStructureProvider $createQuery
     */
    public function __construct(TableStructureProvider $createQuery)
    {
        $this->structureProvider = $createQuery;
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
