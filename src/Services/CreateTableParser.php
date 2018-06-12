<?php

namespace SqlDocumentor\Services;

use PHPSQLParser\PHPSQLParser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SqlDocumentor\Model\Column;
use SqlDocumentor\Model\Table;

/**
 * Class CreateTableParser
 * @package SqlDocumentor\Services
 */
class CreateTableParser
    implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var PHPSQLParser */
    protected $sqlParser;

    /**
     * @return PHPSQLParser
     */
    public function getSqlParser(): PHPSQLParser
    {
        return $this->sqlParser;
    }

    /**
     * @param PHPSQLParser $sqlParser
     * @return CreateTableParser
     */
    public function setSqlParser(PHPSQLParser $sqlParser): CreateTableParser
    {
        $this->sqlParser = $sqlParser;
        return $this;
    }

    /**
     * @param Table $table
     * @param string $sql
     * @return Table
     */
    public function parseTable(Table $table, string $sql): Table
    {
        $parsed = $this->sqlParser->parse($sql);
        $table->setName($parsed['TABLE']['no_quotes']['parts'][0]);

        if (! is_array($parsed['TABLE']['create-def']['sub_tree'])) {
            $this->logger && $this->logger->critical("Invalid parsing columns for table '{$table->getName()}'");
            return $table;
        }

        foreach($parsed['TABLE']['create-def']['sub_tree'] as $createDef)
        {
            switch($createDef['expr_type']) {
                case 'column-def':
                    $this->parseColumn($table, $createDef);
                    break;
                case 'primary-key':
                case 'unique-index':
                case 'index':
                case 'foreign-key':
                    break;
                default:
                    $this->logger && $this->logger->warning("Unknown type: {$createDef['expr_type']}");
            }
        }
        return $table;
    }

    /**
     * @param Table $table
     * @param array $createDef
     */
    protected function parseColumn(Table $table, array $createDef)
    {
        $type = sprintf(
            "%s(%d)",
            $createDef['sub_tree'][1]['sub_tree'][0]['base_expr'],
            $createDef['sub_tree'][1]['sub_tree'][0]['length']
        );

        /** @var Column $column */
        $column = $this->columnFactory->factory($createDef['sub_tree'][0]['no_quotes']['parts'][0]);
        $column->setType($type)
            ->setNullable($createDef['sub_tree'][1]['nullable'] == 1)
            ->setAutoIncrement($createDef['sub_tree'][1]['auto_inc'] == 1);

        if ($createDef['sub_tree'][1]['unique'] == 1) {
            $this->logger && $this->logger->info("Column {$column->getName()} is Unique ?");
            //$attributes[] = $this->output->getInlineCode('Unique');
        }
        if ($createDef['sub_tree'][1]['primary'] == 1) {
            $this->logger && $this->logger->info("Column {$column->getName()} is Primary ?");
            //$attributes[] = $this->output->getInlineCode('Primary');
        }
        $table->addColumn($column);
    }
}
