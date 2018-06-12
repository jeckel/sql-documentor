<?php
namespace SqlDocumentor\Services\Hydrator;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\SQLHydrator\CreateQueryProvider;

/**
 * Class SQLHydrator
 * @package SqlDocumentor\Services\Hydrator
 */
class SQLHydrator
    implements HydratorInterface
{
    /** @var CreateQueryProvider */
    protected $createQueryProvider;

    /**
     * SQLHydrator constructor.
     * @param CreateQueryProvider $createQuery
     */
    public function __construct(CreateQueryProvider $createQuery)
    {
        $this->createQueryProvider = $createQuery;
    }

    /**
     * @param Table $table
     * @return Table
     */
    public function hydrateTable(Table $table): Table
    {
        $query = $this->createQueryProvider->getCreateTable($table->getName());
        return $table;
    }
}
