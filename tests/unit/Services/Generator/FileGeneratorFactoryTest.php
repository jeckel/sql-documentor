<?php
/**
 * User: jeckel
 * Date: 14/06/18
 * Time: 13:30
 */
namespace SqlDocumentor\Tests\Services\Generator;

use Interop\Container\ContainerInterface;
use SqlDocumentor\Services\Generator\FileGenerator;
use SqlDocumentor\Services\Generator\FileGeneratorFactory;
use SqlDocumentor\Services\Generator\TemplateParser;
use Zend\Config\Config;

class FileGeneratorFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @throws \ReflectionException
     */
    public function testInvoke()
    {
        $configPath = $this->createMock(Config::class);
        $configPath->expects($this->exactly(4))
            ->method('get')
            ->willReturnMap([
                ['template', null, 'templateDir'],
                ['target', null, 'targetDir'],
                ['tableTemplate', FileGenerator::DEFAULT_TABLE_TEMPLATE, 'myTable.tpl'],
                ['indexTemplate', FileGenerator::DEFAULT_INDEX_TEMPLATE, 'myIndex.tpl']
            ]);

        $config = $this->createMock(Config::class);
        $config->expects($this->any())
            ->method('get')
            ->with('path')
            ->willReturn($configPath);

        $parser = $this->createMock(TemplateParser::class);
        $container = $this->createMock(ContainerInterface::class);

        $container->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap([
                [ 'config', $config ],
                [ TemplateParser::class, $parser ]
            ]);

        /** @var FileGenerator $generator */
        $generator = (new FileGeneratorFactory())($container, FileGenerator::class);

        $this->assertInstanceOf(FileGenerator::class, $generator);
        $this->assertSame($parser, $generator->getTemplateParser());
        $this->assertEquals('templateDir', $generator->getTemplateDir());
        $this->assertEquals('targetDir', $generator->getTargetDir());
        $this->assertEquals('myTable.tpl', $generator->getTableTemplate());
        $this->assertEquals('myIndex.tpl', $generator->getIndexTemplate());
    }
}
