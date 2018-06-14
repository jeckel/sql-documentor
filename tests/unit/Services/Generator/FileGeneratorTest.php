<?php
/**
 * User: jeckel
 * Date: 14/06/18
 * Time: 11:32
 */
namespace SqlDocumentor\Tests\Services\Generator;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use SqlDocumentor\Model\Table;
use SqlDocumentor\Services\Generator\FileGenerator;
use SqlDocumentor\Services\Generator\TemplateParser;

class FileGeneratorTest extends \Codeception\Test\Unit
{
    /**
     * @var  vfsStreamDirectory
     */
    protected $root;

    /**
     * set up test environmemt
     */
    public function setUp()
    {
        $this->root = vfsStream::setup('exampleDir');
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testGenerateTable()
    {
        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('getName')
            ->willReturn('foobar');

        $content = file_get_contents(__FILE__);

        $parser = $this->createMock(TemplateParser::class);
        $parser->expects($this->once())
            ->method('parse')
            ->with('vfs://exampleDir/table.md.php', ['table' => $table])
            ->willReturn($content);

        $generator = new FileGenerator($parser, vfsStream::url('exampleDir'), vfsStream::url('exampleDir'));
        $this->assertEquals('vfs://exampleDir/foobar.md', $generator->generateTable($table));
        $this->assertTrue($this->root->hasChild('foobar.md'));
        $this->assertSame($content, $this->root->getChild('foobar.md')->getContent());
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testGenerateIndex()
    {
        $table = $this->createMock(Table::class);

        $content = file_get_contents(__FILE__);

        $parser = $this->createMock(TemplateParser::class);
        $parser->expects($this->once())
            ->method('parse')
            ->with('vfs://exampleDir/index.md.php', ['tables' => [$table]])
            ->willReturn($content);

        $generator = new FileGenerator($parser, vfsStream::url('exampleDir'), vfsStream::url('exampleDir'));
        $this->assertEquals('vfs://exampleDir/index.md', $generator->generateIndex([$table]));
        $this->assertTrue($this->root->hasChild('index.md'));
        $this->assertSame($content, $this->root->getChild('index.md')->getContent());
    }
}
