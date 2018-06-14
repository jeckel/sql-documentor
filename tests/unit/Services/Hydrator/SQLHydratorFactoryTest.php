<?php
/**
 * User: jeckel
 * Date: 14/06/18
 * Time: 08:38
 */
namespace SqlDocumentor\Tests\Services\Hydrator;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Model\ColumnFactory;
use SqlDocumentor\Services\Hydrator\SQLHydrator;
use SqlDocumentor\Services\Hydrator\SQLHydratorFactory;

class SQLHydratorFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testInvoke()
    {
        $structureProvider = $this->createMock(SQLHydrator\TableStructureProvider::class);
        $tableHydrator = $this->createMock(SQLHydrator\TableHydrator::class);
        $columnFactory = $this->createMock(ColumnFactory::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(3))
            ->method('get')
            ->willReturnMap([
                [SQLHydrator\TableStructureProvider::class, $structureProvider],
                [SQLHydrator\TableHydrator::class, $tableHydrator],
                [ColumnFactory::class, $columnFactory]
            ]);

        /** @var SQLHydrator $hydrator */
        $hydrator = (new SQLHydratorFactory())($container, SQLHydrator::class);
        $this->assertInstanceOf(SQLHydrator::class, $hydrator);
        $this->assertSame($structureProvider, $hydrator->getStructureProvider());
        $this->assertSame($tableHydrator, $hydrator->getTableHydrator());
        $this->assertSame($columnFactory, $hydrator->getColumnFactory());
    }
}
