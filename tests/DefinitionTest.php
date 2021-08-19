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
        $definition = 'path: src/DummyClass.php, lang: php, match: somepattern';
        yield 'Everything' => [
            "[embed]:# ($definition)",
            $definition,
            '',
            'src/DummyClass.php',
            'php',
            "\034somepattern\034",
        ];
        $definition = 'path: src/DummyClass.php';
        yield 'Only file' => [
            "[embed]:# ($definition)",
            $definition,
            '',
            'src/DummyClass.php',
            'php',
            "\034^.*$\034",
        ];
        $definition = 'path: src/DummyClass.php, match: \'##\sThanks.*$\'';
        yield 'Complex regex' => [
            "[embed]:# ($definition)",
            $definition,
            '',
            'src/DummyClass.php',
            'php',
            "\034##\sThanks.*$\034",
        ];
        $definition = 'path: src/DummyClass, match: \'##\sThanks.*$\'';
        yield 'No file extension' => [
            "[embed]:# ($definition)",
            $definition,
            '',
            'src/DummyClass',
            '',
            "\034##\sThanks.*$\034",
        ];
    }
}
