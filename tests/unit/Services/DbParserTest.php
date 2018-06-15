<?php
/**
 * User: jeckel
 * Date: 13/06/18
 * Time: 23:41
 */
namespace SqlDocumentor\Tests\Services;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\DbParser;
use SqlDocumentor\Services\TableBuilder;

class DbParserTest extends \Codeception\Test\Unit
{
    public function testParseDb()
    {
        $dbh = $this->createMock(\PDO::class);
        $dbh->expects($this->once())
            ->method('query')
            ->with('SHOW TABLES')
            ->willReturn([['table1'], ['table2']]);

        $table1 = $this->createMock(Table::class);
        $table1->expects($this->once())
            ->method('getName')
            ->willReturn('table1');

        $table2 = $this->createMock(Table::class);
        $table2->expects($this->once())
            ->method('getName')
            ->willReturn('table2');

        $tableBuilder = $this->createMock(TableBuilder::class);
        $tableBuilder->expects($this->exactly(2))
            ->method('build')
            ->withConsecutive(['table1'], ['table2'])
            ->willReturnOnConsecutiveCalls($table1, $table2);

        $result = (new DbParser($dbh, $tableBuilder))->parseDb();
        $this->assertEquals(['table1', 'table2'], array_keys($result));
        $this->assertSame($table1, $result['table1']);
        $this->assertSame($table2, $result['table2']);
    }
}
