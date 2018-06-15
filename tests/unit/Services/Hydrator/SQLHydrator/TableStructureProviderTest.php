<?php
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

use Psr\Log\LoggerInterface;
use SqlDocumentor\Services\Hydrator\SQLHydrator\TableStructureProvider;

class TableStructureProviderTest extends \Codeception\Test\Unit
{
    const FIXTURE_PATH = __DIR__ . '/../fixtures/';

    /**
     * @throws \ReflectionException
     */
    public function testGetCreateTable()
    {
        $query = file_get_contents(self::FIXTURE_PATH . 'city.sql');

        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('fetchColumn')
            ->with(1)
            ->willReturn($query);

        $pdo = $this->createMock(\PDO::class);
        $pdo->expects($this->once())
            ->method('query')
            ->with('SHOW CREATE TABLE `foobar`')
            ->willReturn($stmt);

        $provider = new TableStructureProvider($pdo);
        $this->assertSame(trim($query), $provider->getCreateTable('foobar'));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetStructure()
    {
        $query = file_get_contents(self::FIXTURE_PATH . 'city.sql');
        $expected = include self::FIXTURE_PATH . 'tableStructure.php';

        $pdo = $this->createMock(\PDO::class);
        $pdo->expects($this->never())->method('query');

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())->method('warning');

        $provider = new TableStructureProvider($pdo);
        $provider->setLogger($logger);

        $this->assertEquals($expected, $provider->getStructure($query));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetStructureWithUnknownRow()
    {
        $query = "CREATE TABLE `city` (
 foobar baz
) ENGINE=InnoDB";

        $pdo = $this->createMock(\PDO::class);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('warning')
            ->with('Unable to parse row data: foobar baz');

        $provider = new TableStructureProvider($pdo);
        $provider->setLogger($logger);

        $provider->getStructure($query);
    }
}
