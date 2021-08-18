<?php

declare(strict_types=1);

namespace Noem\Composer\Tests;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Noem\Composer\Definition;

class DefinitionTest extends MockeryTestCase
{

    /**
     * @dataProvider definitions
     */
    public function testDefinition(
        string $fullMatch,
        string $definition,
        string $existing,
        string $expectedFile,
        string $expectedLanguage,
        string $expectedPattern,
    ) {
        $sut = new Definition($fullMatch, $definition, $existing);
        $this->assertSame($expectedFile, $sut->file);
        $this->assertSame($expectedLanguage, $sut->language);
        $this->assertSame($expectedPattern, $sut->pattern);
    }

    public function definitions()
    {
        yield 'Everything' => [
            '[embed]:# (src/DummyClass.php php somepattern)',
            'src/DummyClass.php php somepattern',
            '',
            'src/DummyClass.php',
            'php',
            "\034somepattern\034",
        ];

        yield 'Only file' => [
            '[embed]:# (src/DummyClass.php)',
            'src/DummyClass.php',
            '',
            'src/DummyClass.php',
            'php',
            "\034^.*$\034",
        ];
    }
}
