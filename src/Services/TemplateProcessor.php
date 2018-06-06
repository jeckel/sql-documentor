<?php

namespace SqlDocumentor\Services;

/**
 * Class TemplateProcessor
 * @package SqlDocumentor\Services
 */
class TemplateProcessor
{
    /**
     * @param string $template
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function process(string $template, array $params = []): string
    {
        if (! is_readable($template)) {
            throw new \Exception("Template file '$template' is not readable");
        }
        extract($params);
        ob_start();
        include $template;
        return ob_get_clean();
    }

    /**
     * @param string $template
     * @param string $output
     * @param array $params
     * @return TemplateProcessor
     * @throws \Exception
     */
    public function processToFile(string $template, string $output, array $params = []): TemplateProcessor
    {
        if (! is_writable(dirname($output))) {
            throw new \Exception("Output file '$output' is not writable");
        }
        file_put_contents($output, $this->process($template, $params));
        return $this;
    }
}
