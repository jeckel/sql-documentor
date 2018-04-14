<?php

namespace SqlDocumentor;
use PHPSQLParser\PHPSQLParser;
use SqlDocumentor\Table\Column;
use SqlDocumentor\Table\Table;

/**
 * Class Parser
 * @package SqlDocumentor
 */
class Parser
{
    /** @var PHPSQLParser */
    protected $parser;

    /** @var MarkdownGenerator */
    protected $output = '';

    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $this->parser = new PHPSQLParser();
    }

    /**
     * @param $sql
     * @return array
     */
    public function parseSql($sql)
    {
        return $this->parser->parse($sql);
    }

    /**
     * @param $sql
     * @return Table
     */
    public function parse($sql): Table
    {
        $parsed = $this->parseSql($sql);
        print_r($parsed);

        $table = new Table();
        $table->setCreateQuery($sql)
            ->setName($parsed['TABLE']['no_quotes']['parts'][0]);

        foreach($parsed['TABLE']['create-def']['sub_tree'] as $createDef)
        {
            if ($createDef['expr_type'] != 'column-def') {
                printf("Unknown type: %s \n", $createDef['expr_type']);
                continue;
            }

            $type = sprintf(
                "%s(%d)",
                $createDef['sub_tree'][1]['sub_tree'][0]['base_expr'],
                $createDef['sub_tree'][1]['sub_tree'][0]['length']
            );

            $column = new Column();
            $column->setName($createDef['sub_tree'][0]['base_expr'])
                ->setType($type)
                ->setNullable($createDef['sub_tree'][1]['nullable'] == 1)
                ->setAutoIncrement($createDef['sub_tree'][1]['auto_inc'] == 1);

//            if ($createDef['sub_tree'][1]['unique'] == 1) {
//                $attributes[] = $this->output->getInlineCode('Unique');
//            }
//            if ($createDef['sub_tree'][1]['primary'] == 1) {
//                $attributes[] = $this->output->getInlineCode('Primary');
//            }
            $table->addColumn($column);
        }

        return $table;
    }
}
