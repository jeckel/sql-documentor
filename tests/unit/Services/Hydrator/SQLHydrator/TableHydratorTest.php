<?php
/**
 * User: jeckel
 * Date: 13/06/18
 * Time: 19:41
 */
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

use SqlDocumentor\Model\Column;
use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableHydrator;

class TableHydratorTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     * @dataProvider structureProvider
     */
    public function testHydrateTableMeta(array $structure, bool $engine, bool $charset, bool $comment)
    {
        $table = $this->createMock(Table::class);
        if ($engine) {
            $table->expects($this->once())->method('setEngine')->with($structure['engine'])->willReturn($table);
        } else {
            $table->expects($this->never())->method('setEngine');
        }

        if ($charset) {
            $table->expects($this->once())->method('setCharset')->with($structure['charset'])->willReturn($table);
        } else {
            $table->expects($this->never())->method('setCharset');
        }

        if ($comment) {
            $table->expects($this->once())->method('setDescription')->with($structure['comment'])->willReturn($table);
        } else {
            $table->expects($this->never())->method('setDescription');
        }

        $this->assertSame($table, (new TableHydrator())->hydrateTableMeta($table, $structure));
    }

    /**
     * @return array
     */
    public function structureProvider(): array
    {
        return [
            [ ['engine' => 'foo', 'charset' => 'bar', 'comment' => 'baz'], true, true, true ],
            [ ['comment' => 'foo', 'engine' => 'bar', 'charset' => 'baz'], true, true, true ],
            [ ['engine' => 'foo', 'charset' => 'bar', 'comment' => ''], true, true, false ],
            [ ['engine' => 'foo', 'charset' => '', 'comment' => 'baz'], true, false, true ],
            [ ['engine' => '', 'charset' => 'bar', 'comment' => 'baz'], false, true, true ],
            [ ['engine' => '', 'charset' => '', 'comment' => ''], false, false, false ],
            [ ['engine' => 'foo', 'charset' => 'bar'], true, true, false ],
            [ ['engine' => 'foo', 'comment' => 'baz'], true, false, true ],
            [ ['charset' => 'bar', 'comment' => 'baz'], false, true, true ],
            [ [], false, false, false ],
        ];
    }

    /**
     * @param array $params
     * @param bool  $nullable
     * @param bool  $autoIncrement
     * @throws \ReflectionException
     * @dataProvider hydrateColumnProvider
     */
    public function testHydrateColumn(array $params, bool $nullable, bool $autoIncrement)
    {
        $column = $this->createMock(Column::class);
        $column->expects($this->once())
            ->method('setType')
            ->with($params['type'])
            ->willReturn($column);
        $column->expects($this->once())
            ->method('setNullable')
            ->with($nullable)
            ->willReturn($column);

        $column->expects($this->once())
            ->method('setAutoIncrement')
            ->with($autoIncrement)
            ->willReturn($column);

        if (isset($params['comment'])) {
            $column->expects($this->once())
                ->method('setComment')
                ->with($params['comment'])
                ->willReturn($column);
        } else {
            $column->expects($this->never())
                ->method('setComment');
        }

        $this->assertSame($column, (new TableHydrator())->hydrateColumn($column, $params));
    }

    public function hydrateColumnProvider(): array
    {
        return [
            [ ['type' => 'foo', 'null' => true, 'auto-increment' => true, 'comment' => 'foobar'], true, true ],
            [ ['type' => 'foo', 'null' => true, 'auto-increment' => 'foobar', 'comment' => 'foobar'], true, false ],
            [ ['type' => 'foo', 'null' => false], false, false ],
        ];
    }
}
