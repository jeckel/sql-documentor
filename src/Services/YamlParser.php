<?php
namespace SqlDocumentor\Services;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SqlDocumentor\Table\Column;
use SqlDocumentor\Table\Table;

/**
 * Class YamlParser
 * @package SqlDocumentor\Services
 */
class YamlParser
    implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var string */
    protected $ymlDir;

    /**
     * @return string
     */
    public function getYmlDir(): string
    {
        return $this->ymlDir;
    }

    /**
     * @param string $ymlDir
     * @return YamlParser
     */
    public function setYmlDir(string $ymlDir): YamlParser
    {
        $this->ymlDir = $ymlDir;
        return $this;
    }

    /**
     * @param Table $table
     * @return Table
     * @throws \Exception
     */
    public function parse(Table $table): Table
    {
        $filePath = sprintf('%s/%s.yml', $this->ymlDir, $table->getName());
        if (! is_readable($filePath)) {
            $this->logger && $this->logger->warning("No readable YML file for table '{$table->getName()}'");
            return $table;
        }
        $yaml = yaml_parse_file($filePath);

        if (isset($yaml['table'])) {
            $this->updateTable($table, $yaml['table']);
        }

        if (isset($yaml['columns'])) {
            foreach($yaml['columns'] as $colName => $yamlColumn) {
                if (! $table->hasColumn($colName)) {
                    echo "$colName not found";
                    continue;
                }
                $this->updateColumn($table->getColumn($colName), $yamlColumn);
            }
        }
        return $table;
    }

    /**
     * @param Column $column
     * @param array $yaml
     * @return Column
     */
    protected function updateColumn(Column $column, array $yaml): Column
    {
        if (isset($yaml['comment'])) {
            $column->setComment($yaml['comment']);
        }
        return $column;
    }

    /**
     * @param Table $table
     * @param array $yaml
     * @return Table
     */
    protected function updateTable(Table $table, array $yaml): Table
    {
        if (isset($yaml['desc'])) {
            $table->setDescription($yaml['desc']);
        }
        return $table;
    }
}
