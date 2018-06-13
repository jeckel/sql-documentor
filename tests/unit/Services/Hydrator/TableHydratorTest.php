<?php
/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 13/06/18
 * Time: 19:41
 */
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

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

        $hydrator = new TableHydrator();
        $this->assertSame($table, $hydrator->hydrateTableMeta($table, $structure));
    }

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
}
