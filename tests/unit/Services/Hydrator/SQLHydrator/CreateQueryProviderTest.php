<?php
namespace SqlDocumentor\Tests\Services\Hydrator\SQLHydrator;

use Psr\Log\LoggerInterface;
use SqlDocumentor\Services\Hydrator\SQLHydrator\CreateQueryProvider;

class CreateQueryProviderTest extends \Codeception\Test\Unit
{
    const CREATE_QUERY = "CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `area_code` varchar(5) NULL COMMENT 'Code of ''Country'' area',
  `city` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_to_user_ibfk_1` (`id_user`),
  CONSTRAINT `city_to_user_ibfk1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cities of the world'";

    /**
     * @throws \ReflectionException
     */
    public function testGetCreateTable()
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('fetchColumn')
            ->with(1)
            ->willReturn(self::CREATE_QUERY);

        $pdo = $this->createMock(\PDO::class);
        $pdo->expects($this->once())
            ->method('query')
            ->with('SHOW CREATE TABLE `foobar`')
            ->willReturn($stmt);

        $provider = new CreateQueryProvider($pdo);
        $this->assertSame(self::CREATE_QUERY, $provider->getCreateTable('foobar'));
    }

    public function testParseTable()
    {
        $pdo = $this->createMock(\PDO::class);
        $logger = $this->createMock(LoggerInterface::class);

        $provider = new CreateQueryProvider($pdo);
        $provider->setLogger($logger);

        $expected = [
            'table' => [
                'engine'  => 'InnoDB',
                'charset' => 'utf8',
                'comment' => 'Cities of the world'
            ],
            'columns' => [
                'id' => [
                    'type' => 'int(11)',
                    'null' => false,
                    'auto-increment' => true
                ],
                'id_user' => [
                    'type' => 'int(11)',
                    'null' => false,
                ],
                'area_code' => [
                    'type' => 'varchar(5)',
                    'null' => true,
                    'comment' => 'Code of \'Country\' area'
                ],
                'city' => [
                    'type' => 'varchar(64)',
                    'null' => false
                ]
            ],
            'primary-key' => [
                'id'
            ],
            'keys' => [
                'city_to_user_ibfk_1' => [
                    'id_user'
                ]
            ],
            'foreign-keys' => [
                'id_user' => [
                    'table' => 'user',
                    'field' => 'id'
                ]
            ]
        ];

        $this->assertEquals($expected, $provider->parseQuery(self::CREATE_QUERY));
    }
}
