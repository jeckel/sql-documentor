<?php

namespace SqlDocumentor\Services;
use SqlDocumentor\Table\Column;
use SqlDocumentor\Table\Table;

/**
 * Class YamlParser
 * @package SqlDocumentor\Services
 */
class YamlParser
{
    protected $ymlDir;

    public function __construct($dir)
    {
        $this->ymlDir = $dir;
    }

    public function parse(Table $table)
    {
        $filePath = sprintf('%s/%s.yml', $this->ymlDir, $table->getName());
        if (! is_file($filePath)) {
            printf('No YML file for table %s\n', $table->getName());
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

    protected function updateColumn(Column $column, array $yaml): Column
    {
        if (isset($yaml['comment'])) {
            $column->setComment($yaml['comment']);
        }
        return $column;
    }

    protected function updateTable(Table $table, array $yaml): Table
    {
        if (isset($yaml['desc'])) {
            $table->setDescription($yaml['desc']);
        }
        return $table;
    }
}
