<?php
/**
 * User: jeckel
 * Date: 14/06/18
 * Time: 10:43
 */
namespace SqlDocumentor\Tests\Services;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\DbParser;
use SqlDocumentor\Services\Generator\GeneratorInterface;
use SqlDocumentor\Services\SqlDocumentor;

class SqlDocumentorTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testGenerate()
    {
        $table1 = $this->createMock(Table::class);
        $table2 = $this->createMock(Table::class);
        $tableList = [
            'table1' => $table1,
            'table2' => $table2
        ];

        $dbParser = $this->createMock(DbParser::class);
        $dbParser->expects($this->once())
            ->method('parseDb')
            ->willReturn($tableList);

        $generator = $this->createMock(GeneratorInterface::class);
        $generator->expects($this->exactly(2))
            ->method('generateTable')
            ->withConsecutive([$table1], [$table2])
            ->willReturn('');
        $generator->expects($this->once())
            ->method('generateIndex')
            ->with($tableList)
            ->willReturn('');

        $documentor = new SqlDocumentor($dbParser, $generator);
        $this->assertSame($documentor, $documentor->generate());
    }
}
