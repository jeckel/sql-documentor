<?php
namespace SqlDocumentor\Tests\Services\Hydrator\YamlHydrator;

use Codeception\Test\Unit;
use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\YamlHydrator\TableHydrator;

/**
 * Class TableHydratorTest
 * @package SqlDocumentor\Services\Hydrator\YamlHydrator
 */
class TableHydratorTest extends Unit
{
    /**
     * @throws \ReflectionException
     * @test hydrate
     */
    public function testHydrate()
    {
        $yaml = [
            'table' => [
                'desc' => 'Long description',
                'short-desc' => 'Short description'
            ]
        ];

        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('setDescription')
            ->with($yaml['table']['desc'])
            ->willReturn($table);
        $table->expects($this->once())
            ->method('setShortDesc')
            ->with($yaml['table']['short-desc'])
            ->willReturn($table);

        $hydrator = new TableHydrator();

        $this->assertSame($table, $hydrator->hydrate($table, $yaml));
    }

    /**
     * @throws \ReflectionException
     * @test hydrate with empty yaml
     */
    public function testHydrateWithEmptyYaml()
    {
        $table = $this->createMock(Table::class);
        $table->expects($this->never())
            ->method('setDescription');
        $table->expects($this->never())
            ->method('setShortDesc');

        $hydrator = new TableHydrator();

        $this->assertSame($table, $hydrator->hydrate($table, []));
    }
}
