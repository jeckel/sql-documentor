<?php
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\SQLHydrator;

class SQLHydratorTest extends \Codeception\Test\Unit
{
    const FIXTURE_PATH = __DIR__ . '/fixtures/';

    /**
     * @throws \ReflectionException
     */
    public function testHydrateTable()
    {
        $tableName = 'foobar';
        $query = file_get_contents(self::FIXTURE_PATH . 'city.sql');
        $structure = include self::FIXTURE_PATH . 'tableStructure.php';

        $createQueryProvider = $this->createMock(SQLHydrator\TableStructureProvider::class);
        $createQueryProvider->expects($this->once())
            ->method('getCreateTable')
            ->with($tableName)
            ->willReturn($query);

        $createQueryProvider->expects($this->once())
            ->method('getStructure')
            ->with($query)
            ->willReturn($structure);

        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('getName')
            ->willReturn($tableName);

        $table->expects($this->once())
            ->method('setCreateQuery')
            ->with($query)
            ->willReturn($table);

        $sqlHydrator = new SQLHydrator($createQueryProvider);
        $this->assertSame($table, $sqlHydrator->hydrateTable($table));
    }
}
