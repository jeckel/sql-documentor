<?php
namespace SqlDocumentor\Services\Hydrator\YamlHydrator;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Class FileParser
 * @package SqlDocumentor\Services\Hydrator\YamlHydrator
 */
class FileParser implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var string */
    protected $ymlDir;

    /**
     * FileParser constructor.
     * @param string $ymlDir
     */
    public function __construct(string $ymlDir)
    {
        $this->ymlDir = $ymlDir;
    }

    /**
     * @param string $tableName
     * @return array
     */
    public function parseTableFile(string $tableName): array
    {
        $filePath = sprintf('%s/%s.yml', $this->ymlDir, $tableName);
        if (! is_readable($filePath)) {
            $this->logger && $this->logger->warning("No readable YML file for table '{$tableName}'");
            return [];
        }
        return yaml_parse_file($filePath);
    }
}
