<?php
namespace SqlDocumentor\Markdown;

/**
 * Class Markdown
 */
class Markdown
{
    /**
     * @param string $str
     * @return string
     */
    public function getInlineCode(string $str): string
    {
        return sprintf('`%s`', $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public function getBold(string $str): string
    {
        return sprintf('**%s**', $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public function getItalic(string $str): string
    {
        return sprintf('_%s_', $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public function getEmphasis(string $str): string
    {
        return $this->getItalic($str);
    }

    /**
     * @param string $str
     * @return string
     */
    public function getStrongEmphasis(string $str): string
    {
        return $this->getBold($str);
    }

    /**
     * @param string $str
     * @return string
     */
    public function getCombinedEmphasis(string $str): string
    {
        return $this->getBold($this->getItalic($str));
    }

    /**
     * @param string $str
     * @return string
     */
    public function getStrikethrough(string $str): string
    {
        return sprintf('~~%s~~', $str);
    }

    /**
     * @param string $title
     * @param int $level
     * @return string
     */
    public function getTitle(string $title, int $level = 1): string
    {
        return sprintf("\n%s %s\n\n", str_repeat('#', $level), $title);
    }

    /**
     * @param string $str
     * @param int $level
     * @return string
     */
    public function getUnorderedListItem(string $str, $level = 0): string
    {
        return sprintf("%s* %s\n", str_repeat(' ', $level * 2), $str);
    }

    /**
     * @param array $items
     * @param int $level
     * @return string
     */
    public function getUnorderedList(array $items, $level = 0): string
    {
        $toReturn = '';
        foreach ($items as $str) {
            $toReturn .= $this->getUnorderedListItem($str, $level);
        }
        return $toReturn;
    }

    /**
     * @param array $headers
     * @return string
     */
    public function getTableHeaders(array $headers): string
    {
        $toReturn = '';
        foreach($headers as $header) {
            $toReturn .= sprintf('| %s ', $header);
        }
        $toReturn .= "\n";
        $toReturn .= str_repeat('| --- ', count($headers)) . "\n";
        return $toReturn;
    }

    /**
     * @param array $row
     * @return string
     */
    public function getTableRow(array $row): string
    {
        $toReturn = '';
        foreach($row as $cell) {
            $toReturn .= sprintf("| %s ", $cell);
        }
        return $toReturn . "\n";
    }

    /**
     * @param $block
     * @param $language
     * @return string
     */
    public function getCodeBlock($block, $language): string
    {
        return sprintf("```%s \n%s\n```", $language, $block);
    }

    /**
     * @param string $text
     * @param string $target
     * @return string
     */
    public function getLink(string $text, string $target): string
    {
        return sprintf('[%s](%s)', $text, $target);
    }
}
