<?php

namespace SqlDocumentor\Services;
use PHPSQLParser\PHPSQLParser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SqlDocumentor\Table\Column;
use SqlDocumentor\Table\Table;

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
     * @param $sql
     * @return Table
     */
    public function parse(string $sql): Table
    {
        $parsed = $this->sqlParser->parse($sql);

        $this->logger && $this->logger->debug(print_r($parsed, true));

        $table = new Table();
        $table->setCreateQuery($sql)
            ->setName($parsed['TABLE']['no_quotes']['parts'][0]);

        foreach($parsed['TABLE']['create-def']['sub_tree'] as $createDef)
        {
            /*if ($createDef['expr_type'] != 'column-def') {
                printf("Unknown type: %s \n", $createDef['expr_type']);
                continue;
            }*/

            switch($createDef['expr_type']) {
                case 'column-def':
                    $this->parseColumn($table, $createDef);
                    break;
                case 'index':
                case 'foreign-key':
                    break;
                default:
                    printf("Unknown type: %s \n", $createDef['expr_type']);
            }
        }

        return $table;
    }


    protected function parseColumn(Table $table, array $createDef)
    {
        $type = sprintf(
            "%s(%d)",
            $createDef['sub_tree'][1]['sub_tree'][0]['base_expr'],
            $createDef['sub_tree'][1]['sub_tree'][0]['length']
        );

        //var_dump($createDef['sub_tree']);

        $column = new Column();
        $column->setName($createDef['sub_tree'][0]['no_quotes']['parts'][0])
            ->setType($type)
            ->setNullable($createDef['sub_tree'][1]['nullable'] == 1)
            ->setAutoIncrement($createDef['sub_tree'][1]['auto_inc'] == 1);

        if ($createDef['sub_tree'][1]['unique'] == 1) {
            printf('Unique\n');
            //$attributes[] = $this->output->getInlineCode('Unique');
        }
        if ($createDef['sub_tree'][1]['primary'] == 1) {
            printf('Primary\n');
            //$attributes[] = $this->output->getInlineCode('Primary');
        }
        $table->addColumn($column);
    }
}
