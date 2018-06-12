<?php
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\SQLHydrator;

class SQLHydratorTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testHydrateTable()
    {
        $tableName = 'foobar';
        $sql = "CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_code` varchar(5) NOT NULL COMMENT 'Code of ''Country'' area',
  `city` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cities of the world'";

        $createQueryProvider = $this->createMock(SQLHydrator\CreateQueryProvider::class);
        $createQueryProvider->expects($this->once())
            ->method('getCreateTable')
            ->with($tableName)
            ->willReturn($sql);

        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('getName')
            ->willReturn($tableName);

        $sqlHydrator = new SQLHydrator($createQueryProvider);
        $this->assertSame($table, $sqlHydrator->hydrateTable($table));
    }
}
