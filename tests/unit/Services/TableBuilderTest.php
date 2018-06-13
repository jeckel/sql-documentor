<?php
/**
 * User: jeckel
 * Date: 13/06/18
 * Time: 23:18
 */
namespace SqlDocumentor\Tests\Services;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Model\TableFactory;
use SqlDocumentor\Services\Hydrator\SQLHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator;
use SqlDocumentor\Services\TableBuilder;

class TableBuilderTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testBuild()
    {
        $name = 'foobar';
        $table1 = $this->createMock(Table::class);
        $table2 = $this->createMock(Table::class);
        $table3 = $this->createMock(Table::class);

        $factory = $this->createMock(TableFactory::class);
        $factory->expects($this->once())
            ->method('factory')
            ->with($name)
            ->willReturn($table1);

        $sqlHydrator = $this->createMock(SQLHydrator::class);
        $sqlHydrator->expects($this->once())
            ->method('hydrateTable')
            ->with($table1)
            ->willReturn($table2);

        $yamlHydrator = $this->createMock(YamlHydrator::class);
        $yamlHydrator->expects($this->once())
            ->method('hydrateTable')
            ->with($table2)
            ->willReturn($table3);

        $builder = new TableBuilder($factory, $sqlHydrator, $yamlHydrator);
        $this->assertSame($table3, $builder->build($name));
    }
}
