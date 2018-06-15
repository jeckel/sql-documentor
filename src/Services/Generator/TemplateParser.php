<?php
namespace SqlDocumentor\Services\Generator;

use SqlDocumentor\Services\Generator\Exception\UnexpectedValueException;

/**
 * Class TemplateParser
 * @package SqlDocumentor\Services\Generator
 */
class TemplateParser
{
    /**
     * @param string $template
     * @param array  $params
     * @return string
     * @throws \Exception
     */
    public function parse(string $template, array $params = []): string
    {
        if (! is_readable($template)) {
            throw new UnexpectedValueException("Template file '$template' is not readable");
        }
        extract($params);
        ob_start();
        include $template;
        return ob_get_clean();
    }
}
