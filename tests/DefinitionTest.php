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
        string $rawEmbed,
        string $definition,
        string $existing,
        string $expectedFile,
        string $expectedLanguage,
        string $expectedPattern,
    )
    {
        $sut = new Definition($fullMatch, $rawEmbed, $definition, $existing);
        $this->assertSame($expectedFile, $sut->file);
        $this->assertSame($expectedLanguage, $sut->language);
        $this->assertSame($expectedPattern, $sut->pattern);
    }

    public function definitions()
    {
        $definition = 'path: src/DummyClass.php, lang: php, match: somepattern';
        $rawEmbed = "[embed]:# ($definition)";
        yield 'Everything' => [
            "[embed]:# ($definition)",
            $rawEmbed,
            $definition,
            '',
            'src/DummyClass.php',
            'php',
            "\034somepattern\034",
        ];
        $definition = 'path: src/DummyClass.php';
        $rawEmbed = "[embed]:# ($definition)";
        yield 'Only file' => [
            "[embed]:# ($definition)",
            $rawEmbed,
            $definition,
            '',
            'src/DummyClass.php',
            'php',
            "\034^.*$\034",
        ];
        $definition = 'path: src/DummyClass.php, match: \'##\sThanks.*$\'';
        $rawEmbed = "[embed]:# ($definition)";
        yield 'Complex regex' => [
            "[embed]:# ($definition)",
            $rawEmbed,
            $definition,
            '',
            'src/DummyClass.php',
            'php',
            "\034##\sThanks.*$\034",
        ];
        $definition = 'path: src/DummyClass, match: \'##\sThanks.*$\'';
        $rawEmbed = "[embed]:# ($definition)";
        yield 'No file extension' => [
            "[embed]:# ($definition)",
            $rawEmbed,
            $definition,
            '',
            'src/DummyClass',
            '',
            "\034##\sThanks.*$\034",
        ];
    }
}
