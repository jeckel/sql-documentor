<?php
namespace SqlDocumentor\Services\Hydrator\SQLHydrator;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Class CreatQueryProvider
 * @package SqlDocumentor\Services\Hydrator\SQLHydrator
 */
class CreateQueryProvider
    implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var \PDO */
    protected $dbh;

    /**
     * CreateQueryProvider constructor.
     * @param \PDO $dbh
     */
    public function __construct(\PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @param string $tableName
     * @return string
     */
    public function getCreateTable(string $tableName): string
    {
        return $this->dbh->query(
            sprintf('SHOW CREATE TABLE `%s`', $tableName)
        )->fetchColumn(1);
    }

    /**
     * @param string $query
     * @return array
     */
    public function parseQuery(string $query): array
    {
        $rows = explode("\n", $query);
        $toReturn = [ 'table' => $this->parseTableMeta( $rows[count($rows) - 1])];

        for($i = 1; $i < count($rows)-1; $i++) {
            // cleanup string
            $row = trim($rows[$i], ' ,()');

            if (preg_match('/^`([a-zA-Z0-9_-]*)` (.*)$/m', $row, $matches)) {
                $toReturn['columns'][$matches[1]] = $this->parseColumnMeta($matches[2]);
            } elseif (strpos($row, 'PRIMARY KEY') === 0) {
                $toReturn['primary-key'] = $this->parsePrimaryKey($row);
            } elseif (strpos($row, 'KEY') === 0) {
                $toReturn['keys'][] = $this->parseKey($row);
            } elseif (strpos($row, 'CONSTRAINT') === 0git res) {
                $toReturn['foreign-keys'][] = $this->parseForeignKey($row);
            } else {
                $this->logger->warning("Unable to parse row data: {$row}");
            }
        }

        return $toReturn;
    }

    /**
     * @param string $meta
     * @return array
     */
    protected function parseColumnMeta(string $meta): array
    {
        $toReturn = [];
        $toReturn['type'] = substr($meta, 0, strpos($meta, ' '));
        $meta = substr($meta, strpos($meta, ' ') + 1);
        $toReturn['null'] = (strpos($meta, 'NULL') === 0);
        $meta = substr($meta, strpos($meta, 'NULL') + 5);
        if (strpos($meta, 'AUTO_INCREMENT') !== false) {
            $toReturn['auto-increment'] = true;
        }
        if (($comment = $this->extractComment($meta)) != '') {
            $toReturn['comment'] = $comment;
        }
        return $toReturn;
    }

    /**
     * @param string $meta
     * @return array
     */
    protected function parseTableMeta(string $meta): array
    {
        preg_match_all('/ ([ A-Z]+)=([A-Za-z0-9]*)/m', $meta, $matches, PREG_SET_ORDER, 0);
        $toReturn = [];
        foreach($matches as $match) {
            switch(strtoupper($match[1])) {
                case 'ENGINE':
                    $toReturn['engine'] = $match[2];
                    break;
                case 'DEFAULT CHARSET':
                    $toReturn['charset'] = $match[2];
                    break;
                case 'COMMENT':
                    $toReturn['comment'] = $this->extractComment($meta);
                    break;
            }
        }
        return $toReturn;
    }

    /**
     * @param string $str
     * @return array
     */
    protected function parsePrimaryKey(string $str): array
    {
        preg_match_all('/`([a-zA-Z0-9_]*)`/m', $str, $matches, PREG_SET_ORDER, 0);
        $toReturn = [];
        foreach($matches as $match) {
            $toReturn[] = $match[1];
        }
        return $toReturn;
    }

    /**
     * @param string $str
     * @return array
     */
    protected function parseKey(string $str): array
    {
        $toReturn = [];
        return $toReturn;
    }

    /**
     * @param string $str
     * @return array
     */
    protected function parseForeignKey(string $str): array
    {
        $toReturn = [];
        return $toReturn;
    }

    /**
     * @param string $str
     * @return string
     */
    protected function extractComment(string $str): string
    {
        if (strpos($str, 'COMMENT') === false) {
            return '';
        }
        $str = substr($str, strpos($str, 'COMMENT')+9, -1);
        $str = str_replace('\'\'', '\'', $str);
        return $str;
    }
}
