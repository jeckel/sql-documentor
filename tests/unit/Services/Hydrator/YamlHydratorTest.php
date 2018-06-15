<?php
namespace SqlDocumentor\Tests\Services\Hydrator;

use Codeception\Test\Unit;
use Psr\Log\LoggerInterface;
use SqlDocumentor\Model\Column;
use SqlDocumentor\Model\Exception\ColumnNotFoundException;
use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\YamlHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator\FileParser;
use SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator;

/**
 * Class YamlHydratorTest
 */
class YamlHydratorTest extends Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testHydrateTable()
    {
        $tableName = 'foobar';
        $yaml = [
            'table' => [
                'desc' => 'Long description',
                'short-desc' => 'Short description'
            ],
            'columns' => [
                'id' => [
                    'comment' => 'Column description',
                    'flags' => [
                        'foo',
                        'bar'
                    ]
                ],
                'undefined_column' => [
                    'comment' => 'Should not be hydrated but should write an error log'
                ]
            ]
        ];

        $exceptionMessage = 'column not found';

        $fileParser = $this->createMock(FileParser::class);
        $fileParser->expects($this->once())
            ->method('parseTableFile')
            ->with($tableName)
            ->willReturn($yaml);

        $idColumn = $this->createMock(Column::class);

        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('getName')
            ->willReturn($tableName);
        $table->expects($this->at(1))
            ->method('getColumn')
            ->with('id')
            ->willReturn($idColumn);
        $table->expects($this->at(2))
            ->method('getColumn')
            ->with('undefined_column')
            ->willThrowException(new ColumnNotFoundException($exceptionMessage));

        $tableHydrator = $this->createMock(TableHydrator::class);
        $tableHydrator->expects($this->once())
            ->method('hydrate')
            ->with($table, $yaml)
            ->willReturn($table);

        $columnHydrator = $this->createMock(ColumnHydrator::class);
        $columnHydrator->expects($this->once())
            ->method('hydrate')
            ->with($idColumn, $yaml['columns']['id'])
            ->willReturn($idColumn);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('error')
            ->with($exceptionMessage);

        $hydrator = new YamlHydrator($fileParser, $tableHydrator, $columnHydrator);
        $hydrator->setLogger($logger);

        $this->assertSame($table, $hydrator->hydrateTable($table));
    }
}
