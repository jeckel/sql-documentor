<?php
/**
 * User: jeckel
 * Date: 13/06/18
 * Time: 23:11
 */
namespace SqlDocumentor\Tests\Model;

use SqlDocumentor\Model\Table;
use SqlDocumentor\Model\TableFactory;

/**
 * Class TableFactoryTest
 * @package SqlDocumentor\Tests\Model
 */
class TableFactoryTest extends \Codeception\Test\Unit
{
    /**
     *
     */
    protected function setUp()
    {
        TableFactory::reset();
        return parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @test factory
     */
    public function testFactory()
    {
        $name = 'foobar';

        $table = (new TableFactory())->factory($name);
        $this->assertInstanceOf(Table::class, $table);
        $this->assertEquals($name, $table->getName());

        $this->assertSame($table, (new TableFactory())->factory($name));
    }
}
