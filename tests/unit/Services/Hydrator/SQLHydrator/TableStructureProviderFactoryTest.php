<?php
/**
 * User: jeckel
 * Date: 13/06/18
 * Time: 23:31
 */
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProvider;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProviderFactory;

class TableStructureProviderFactoryTest extends \Codeception\Test\Unit
{

    public function test__invoke()
    {
        $dbh = $this->createMock(\PDO::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())
            ->method('get')
            ->with('dbh')
            ->willReturn($dbh);

        $provider = (new TableStructureProviderFactory())($container, TableStructureProvider::class);
        $this->assertInstanceOf(TableStructureProvider::class, $provider);
        $this->assertSame($dbh, $provider->getDbh());
    }
}
