<?php
namespace SqlDocumentor\Services\Generator;

use SqlDocumentor\Model\Table;

/**
 * Class FileGenerator
 * @package SqlDocumentor\Services\Generator
 */
class FileGenerator implements GeneratorInterface
{
    const DEFAULT_TABLE_TEMPLATE = 'table.md.php';
    const DEFAULT_INDEX_TEMPLATE = 'index.md.php';

    /** @var string */
    protected $templateDir = '';

    /** @var string */
    protected $targetDir = '';

    /** @var string */
    protected $tableTemplate = '';

    /** @var string */
    protected $indexTemplate = '';

    /** @var TemplateParser */
    protected $templateParser;

    /**
     * FileGenerator constructor.
     * @param TemplateParser $templateParser
     * @param string         $templateDir
     * @param string         $targetDir
     * @param string         $tableTemplate
     * @param string         $indexTemplate
     */
    public function __construct(
        TemplateParser $templateParser,
        string $templateDir,
        string $targetDir,
        string $tableTemplate = self::DEFAULT_TABLE_TEMPLATE,
        string $indexTemplate = self::DEFAULT_INDEX_TEMPLATE
    ) {
        $this->templateParser = $templateParser;
        $this->templateDir = $templateDir;
        $this->targetDir = $targetDir;
        $this->tableTemplate = $tableTemplate;
        $this->indexTemplate = $indexTemplate;
    }

    /**
     * @return string
     */
    public function getTemplateDir(): string
    {
        return $this->templateDir;
    }

    /**
     * @return string
     */
    public function getTargetDir(): string
    {
        return $this->targetDir;
    }

    /**
     * @return string
     */
    public function getTableTemplate(): string
    {
        return $this->tableTemplate;
    }

    /**
     * @return string
     */
    public function getIndexTemplate(): string
    {
        return $this->indexTemplate;
    }

    /**
     * @return TemplateParser
     */
    public function getTemplateParser(): TemplateParser
    {
        return $this->templateParser;
    }

    /**
     * @param Table $table
     * @return string
     * @throws \Exception
     */
    public function generateTable(Table $table): string
    {
        $target = $this->targetDir . '/' . $table->getName() . '.md';
        $this->generateTemplate(
            $this->templateDir . '/' . $this->tableTemplate,
            $target,
            [ 'table' => $table ]
        );
        return $target;
    }

    /**
     * @param array $tables
     * @return string
     * @throws \Exception
     */
    public function generateIndex(array $tables): string
    {
        $target = $this->targetDir . '/index.md';
        $this->generateTemplate(
            $this->templateDir . '/' .$this->indexTemplate,
            $target,
            [ 'tables' => $tables ]
        );
        return $target;
    }

    /**
     * @param string $template
     * @param string $output
     * @param array  $params
     * @throws \Exception
     */
    protected function generateTemplate(string $template, string $output, array $params = [])
    {
        file_put_contents(
            $output,
            $this->templateParser->parse(
                $template,
                $params
            )
        );
    }
}
