<?php
/**
 * User: jeckel
 * Date: 14/06/18
 * Time: 08:46
 */
namespace SqlDocumentor\Tests\Services\Hydrator;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\Hydrator\YamlHydrator;
use SqlDocumentor\Services\Hydrator\YamlHydratorFactory;

class YamlHydratorFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testInvoke()
    {
        $fileParser = $this->createMock(YamlHydrator\FileParser::class);
        $tableHydrator = $this->createMock(YamlHydrator\TableHydrator::class);
        $columnHydrator = $this->createMock(YamlHydrator\ColumnHydrator::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(3))
            ->method('get')
            ->willReturnMap([
                [ YamlHydrator\FileParser::class, $fileParser ],
                [ YamlHydrator\TableHydrator::class, $tableHydrator ],
                [ YamlHydrator\ColumnHydrator::class, $columnHydrator ]
            ]);

        /** @var YamlHydrator $hydrator */
        $hydrator = (new YamlHydratorFactory())($container, YamlHydrator::class);
        $this->assertInstanceOf(YamlHydrator::class, $hydrator);
        $this->assertSame($fileParser, $hydrator->getFileParser());
        $this->assertSame($tableHydrator, $hydrator->getTableHydrator());
        $this->assertSame($columnHydrator, $hydrator->getColumnHydrator());
    }
}
