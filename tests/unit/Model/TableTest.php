<?php
namespace SqlDocumentor\Tests\Model;

use SqlDocumentor\Model\Table;

class TableTest extends \Codeception\Test\Unit
{
    public function testConstructAndGetName()
    {
        $table = new Table('foobar');
        $this->assertEquals('foobar', $table->getName());
    }

    public function testSetAndGetDescription()
    {
        $table = new Table('');
        $this->assertSame($table, $table->setDescription('foobar'));
        $this->assertEquals('foobar', $table->getDescription());
    }

    public function testSetAndGetShortDesc()
    {
        $table = new Table('');
        $this->assertSame($table, $table->setShortDesc('foobar'));
        $this->assertEquals('foobar', $table->getShortDesc());
    }

    public function testSetAndGetCreateQuery()
    {
        $table = new Table('');
        $this->assertSame($table, $table->setCreateQuery('foobar'));
        $this->assertEquals('foobar', $table->getCreateQuery());
    }

    public function testSetAndGetEngine()
    {
        $table = new Table('');
        $this->assertSame($table, $table->setEngine('foobar'));
        $this->assertEquals('foobar', $table->getEngine());
    }

    public function testSetAndGetCharset()
    {
        $table = new Table('');
        $this->assertSame($table, $table->setCharset('foobar'));
        $this->assertEquals('foobar', $table->getCharset());
    }
}
