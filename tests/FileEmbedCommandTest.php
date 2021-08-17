<?php

declare(strict_types=1);

namespace Noem\Composer\Tests;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Noem\Composer\FileEmbedCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileEmbedCommandTest extends MockeryTestCase
{

    /**
     * @var bool
     */
    private $baseDir;

    public function setUp(): void
    {
        parent::setUp();
        $tmp = sys_get_temp_dir();
        $this->baseDir = $tmp.'/embedme-files';
        if(!is_dir($this->baseDir)){
            mkdir($this->baseDir);
            copy(__DIR__.'/files/README.md',$this->baseDir.'/README.md');
            copy(__DIR__.'/files/embedme.php',$this->baseDir.'/embedme.php');
        }
    }

    public function tearDown():void
    {
        parent::tearDown();
        array_map('unlink', glob("{$this->baseDir}/*.*"));
        rmdir((string)$this->baseDir);
    }

    public function testFileEmbed()
    {
        $sut = new FileEmbedCommand($this->baseDir);
        $input = \Mockery::mock(InputInterface::class);
        $output = \Mockery::mock(OutputInterface::class);
        $output->shouldReceive('writeLn');
        $method = (new \ReflectionClass(FileEmbedCommand::class))->getMethod('execute');
        $method->setAccessible(true);
        $before=file_get_contents($this->baseDir.'/README.md');

        $method->invoke($sut, $input, $output);
        $after=file_get_contents($this->baseDir.'/README.md');
        $this->assertNotSame($before,$after);
    }
}
