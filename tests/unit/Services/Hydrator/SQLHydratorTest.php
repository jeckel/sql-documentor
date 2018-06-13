<?php
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

use SqlDocumentor\Model\Column;
use SqlDocumentor\Model\ColumnFactory;
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

        $tableHydrator = $this->createMock(SQLHydrator\TableHydrator::class);

        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('getName')
            ->willReturn($tableName);

        $table->expects($this->once())
            ->method('setCreateQuery')
            ->with($query)
            ->willReturn($table);

        $column1 = $this->createMock(Column::class);
        $column2 = $this->createMock(Column::class);
        $column3 = $this->createMock(Column::class);
        $column4 = $this->createMock(Column::class);

        $columnFactory = $this->createMock(ColumnFactory::class);
        $columnFactory->expects($this->exactly(4))
            ->method('factory')
            ->withConsecutive(
                [$table, 'id'],
                [$table, 'id_user'],
                [$table, 'area_code'],
                [$table, 'city']
            )
            ->willReturnOnConsecutiveCalls($column1, $column2, $column3, $column4);

        $tableHydrator->expects($this->exactly(4))
            ->method('hydrateColumn')
            ->withConsecutive(
                [$column1, $structure['columns']['id']],
                [$column2, $structure['columns']['id_user']],
                [$column3, $structure['columns']['area_code']],
                [$column4, $structure['columns']['city']]
            )->willReturnOnConsecutiveCalls($column1, $column2, $column3, $column4);

        $sqlHydrator = new SQLHydrator($createQueryProvider, $tableHydrator, $columnFactory);
        $this->assertSame($table, $sqlHydrator->hydrateTable($table));
    }
}
