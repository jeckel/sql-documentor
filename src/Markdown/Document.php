<?php

namespace SqlDocumentor\Markdown;

/**
 * Class Document
 * @package SqlDocumentor\Markdown
 */
class Document
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $content;

    /** @var array */
    protected $summary = [];

    /** @var Markdown */
    protected $markdown;

    /** @var string */
    protected $outputDir;

    /**
     * Document constructor.
     */
    public function __construct($name, $outputDir)
    {
        $this->name = $name;
        $this->outputDir = $outputDir;
        $this->markdown = new Markdown();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Document
     */
    public function setName(string $name): Document
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $title
     * @param $link
     * @param int $level
     * @return Document
     */
    public function addSummaryItem($title, $link, $level = 1): Document
    {
        $this->summary[] = ['title' => $title, 'target' => $link, 'level' => $level];
        return $this;
    }

    /**
     * @param string $title
     * @param int $level
     * @return Document
     */
    public function addTitle(string $title, int $level = 1): Document
    {
        $link = '#' . preg_replace(['/[ ]/', '/`/'], ['-', ''], strtolower($title));
        return $this->addSummaryItem($title, $link, $level)
            ->addContent($this->markdown->getTitle($title, $level));
    }

    /**
     * @param string $content
     * @return Document
     */
    public function addContent(string $content): Document
    {
        $this->content .= $content;
        return $this;
    }

    /**
     * @return string
     */
    public function export(): string
    {
        $outputFile = sprintf('%s/%s.md',
            $this->outputDir,
            $this->name
        );
        file_put_contents(
            $outputFile,
            $this->getOutput()
        );
        return $outputFile;
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        $content = '';
        foreach ($this->summary as $item) {
            $content .= $this->markdown->getUnorderedListItem(
                $this->markdown->getLink($item['title'], $item['target']),
                $item['level']
            );
        }
        $content .= $this->content;
        return $content;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getOutput();
    }
}
