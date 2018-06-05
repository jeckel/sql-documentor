<?php

namespace SqlDocumentor;
use SqlDocumentor\Table\Table;

/**
 * Class TemplateGenerator
 * @package SqlDocumentor
 */
class TemplateGenerator
{
    protected $outputDir;

    public function __construct(string $outputDir)
    {
        $this->outputDir = $outputDir;
    }

    public function generate(Table $table, string $template): self
    {
        ob_start();
        include $template;
        $content = ob_get_clean();

        file_put_contents(
            sprintf('%s/%s.md', $this->outputDir, $table->getName()),
            $content
        );
        return $this;
    }
}
