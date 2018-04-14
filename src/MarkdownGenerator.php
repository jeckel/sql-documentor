<?php

namespace SqlDocumentor;
use SqlDocumentor\Markdown\Document;
use SqlDocumentor\Markdown\Markdown;
use SqlDocumentor\Table\Column;
use SqlDocumentor\Table\Table;

/**
 * Class MarkdownGenerator
 * @package SqlDocumentor
 */
class MarkdownGenerator
{
    /** @var Markdown */
    protected $markdown;

    /**
     * MarkdownGenerator constructor.
     */
    public function __construct()
    {
        $this->markdown = new Markdown();
    }

    /**
     * @param Table $table
     * @return Document
     */
    public function generate(Table $table): Document
    {
        $document = new Document($table->getName(), realpath(__DIR__.'/../doc'));
        $document->addTitle(sprintf('Table %s', $this->markdown->getInlineCode($table->getName())))
            ->addTitle('Columns', 2)
            ->addContent($this->markdown->getTableHeaders(['Column', 'Type', 'Attributes', 'Comments']));

        /** @var Column $column */
        foreach ($table->getColumns() as $column)
        {
            $attributes = [ $this->markdown->getInlineCode($column->isNullable() ? 'NULL' : 'NOT NULL') ];
            if ($column->isAutoIncrement()) {
                $attributes[] = $this->markdown->getInlineCode('Auto-Increment');
            }

            $document->addContent(
                $this->markdown->getTableRow([
                    $column->getName(),
                    $this->markdown->getInlineCode($column->getType()),
                    implode(', ', $attributes),
                    $column->getComment()
                ])
            );
        }

        $document->addTitle('Create query', 2)
            ->addContent($this->markdown->getCodeBlock($table->getCreateQuery(), 'sql'));
        return $document;
    }
}
