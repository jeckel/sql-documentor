<?php
namespace SqlDocumentor\Tests\Services\Hydrator\YamlHydrator;

use Codeception\Test\Unit;
use SqlDocumentor\Model\Column;
use SqlDocumentor\Services\Hydrator\YamlHydrator\ColumnHydrator;

class ColumnHydratorTest extends Unit
{
    /**
     * @throws \ReflectionException
     * @test hydrate
     */
    public function testHydrate()
    {
        $yaml = [
            'comment' => 'My column comment',
            'flags' => [
                'foo',
                'bar'
            ]
        ];

        $column = $this->createMock(Column::class);

        $column->expects($this->once())
            ->method('setComment')
            ->with($yaml['comment'])
            ->willReturn($column);

        $column->expects($this->exactly(2))
            ->method('addFlag')
            ->withConsecutive(['FOO'], ['BAR'])
            ->willReturn($column);

        $hydrator = new ColumnHydrator();

        $this->assertSame($column, $hydrator->hydrate($column, $yaml));
    }
}
