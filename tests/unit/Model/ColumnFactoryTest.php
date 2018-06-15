<?php

/**
 * User: jeckel
 * Date: 13/06/18
 * Time: 22:27
 */

namespace SqlDocumentor\Tests\Model;

use SqlDocumentor\Model\Column;
use SqlDocumentor\Model\ColumnFactory;
use SqlDocumentor\Model\Table;

class ColumnFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testFactoryNewColumn()
    {
        $name = 'foobar';

        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('hasColumn')
            ->with($name)
            ->willReturn(false);
        $table->expects($this->never())
            ->method('getColumn');

        $table->expects($this->once())
            ->method('addColumn')
            ->with($this->callback(function ($column) use ($name, &$addedColumn) {
                $this->assertInstanceOf(Column::class, $column);
                $this->assertEquals($name, $column->getName());
                $addedColumn = $column;
                return true;
            }))
            ->willReturn($table);

        $column = (new ColumnFactory())->factory($table, $name);
        $this->assertInstanceOf(Column::class, $column);
        $this->assertEquals($name, $column->getName());
        $this->assertSame($addedColumn, $column);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFactoryExistingColumn()
    {
        $name = 'foobar';

        $column = $this->createMock(Column::class);

        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('hasColumn')
            ->with($name)
            ->willReturn(true);
        $table->expects($this->once())
            ->method('getColumn')
            ->with($name)
            ->willReturn($column);
        $table->expects($this->never())
            ->method('addColumn');

        $this->assertSame($column, (new ColumnFactory())->factory($table, $name));
    }
}
