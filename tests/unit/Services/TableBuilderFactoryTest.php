<?php
/**
 * User: jeckel
 * Date: 14/06/18
 * Time: 10:28
 */
namespace SqlDocumentor\Tests\Services;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Model\TableFactory;
use SqlDocumentor\Services\Hydrator\SQLHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydrator;
use SqlDocumentor\Services\TableBuilder;
use SqlDocumentor\Services\TableBuilderFactory;

class TableBuilderFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testInvoke()
    {
        $tableFactory = $this->createMock(TableFactory::class);
        $sqlHydrator = $this->createMock(SQLHydrator::class);
        $yamlHydrator = $this->createMock(YamlHydrator::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(3))
            ->method('get')
            ->willReturnMap([
                [ TableFactory::class, $tableFactory ],
                [ SQLHydrator::class, $sqlHydrator ],
                [ YamlHydrator::class, $yamlHydrator ]
            ]);

        /** @var TableBuilder $tableBuilder */
        $tableBuilder = (new TableBuilderFactory())($container, TableBuilder::class);
        $this->assertInstanceOf(TableBuilder::class, $tableBuilder);
        $this->assertSame($tableFactory, $tableBuilder->getTableFactory());
        $this->assertSame($sqlHydrator, $tableBuilder->getSqlHydrator());
        $this->assertSame($yamlHydrator, $tableBuilder->getYamlHydrator());
    }
}
