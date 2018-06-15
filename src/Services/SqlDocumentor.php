<?php
namespace SqlDocumentor\Services;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Generator\GeneratorInterface;

/**
 * Class SqlDocumentor
 * @package SqlDocumentor\Services
 */
class SqlDocumentor
{
    /** @var DbParser */
    protected $dbParser;

    /** @var GeneratorInterface */
    protected $generator;

    /**
     * SqlDocumentor constructor.
     * @param DbParser           $dbParser
     * @param GeneratorInterface $generator
     */
    public function __construct(DbParser $dbParser, GeneratorInterface $generator)
    {
        $this->dbParser = $dbParser;
        $this->generator = $generator;
    }

    /**
     * @return SqlDocumentor
     */
    public function generate(): self
    {
        $tables = $this->dbParser->parseDb();

        /** @var Table $table */
        foreach ($tables as $table) {
            $this->generator->generateTable($table);
        }
        $this->generator->generateIndex($tables);

        return $this;
    }
}
