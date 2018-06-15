<?php
/**
 * User: jeckel
 * Date: 14/06/18
 * Time: 08:54
 */
namespace SqlDocumentor\Tests\Services;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\DbParser;
use SqlDocumentor\Services\DbParserFactory;
use SqlDocumentor\Services\TableBuilder;

class DbParserFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testInvoke()
    {
        $dbh = $this->createMock(\PDO::class);
        $tableBuilder = $this->createMock(TableBuilder::class);
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap([
                [ 'dbh', $dbh ],
                [ TableBuilder::class, $tableBuilder ]
            ]);

        /** @var DbParser $dbParser */
        $dbParser = (new DbParserFactory())($container, DbParser::class);
        $this->assertInstanceOf(DbParser::class, $dbParser);
        $this->assertSame($dbh, $dbParser->getDbh());
        $this->assertSame($tableBuilder, $dbParser->getTableBuilder());
    }
}
