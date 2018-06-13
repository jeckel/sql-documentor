<?php
namespace SqlDocumentor\Services\Hydrator;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SqlDocumentor\Model\Exception\ColumnNotFoundException;
use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator\FileParser;
use SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator;

/**
 * Class YamlHydrator
 * @package SqlDocumentor\Services\Hydrator
 */
class YamlHydrator implements HydratorInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var FileParser */
    protected $fileParser;

    /** @var TableHydrator */
    protected $tableHydrator;

    /** @var ColumnHydrator */
    protected $columnHydrator;

    /**
     * YamlHydrator constructor.
     * @param FileParser $fileParser
     * @param TableHydrator $tableHydrator
     * @param ColumnHydrator $columnHydrator
     */
    public function __construct(
        FileParser     $fileParser,
        TableHydrator  $tableHydrator,
        ColumnHydrator $columnHydrator
    ) {
        $this->fileParser     = $fileParser;
        $this->tableHydrator  = $tableHydrator;
        $this->columnHydrator = $columnHydrator;
    }

    /**
     * @param Table $table
     * @return Table
     */
    public function hydrateTable(Table $table): Table
    {
        $yaml = $this->fileParser->parseTableFile($table->getName());
        $this->tableHydrator->hydrate($table, $yaml);

        if (isset($yaml['columns'])) {
            foreach ($yaml['columns'] as $colName => $yamlColumn) {
                try {
                    $column = $table->getColumn($colName);
                } catch (ColumnNotFoundException $e) {
                    // Column defined in YML file but not in the Table object
                    $this->logger->error($e->getMessage());
                    continue;
                }
                $this->columnHydrator->hydrate($column, $yamlColumn);
            }
        }

        return $table;
    }
}
