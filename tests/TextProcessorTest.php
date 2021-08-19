<?php

declare(strict_types=1);

namespace Noem\Composer\Tests;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Noem\Composer\Definition;
use Noem\Composer\TextProcessor;

class TextProcessorTest extends MockeryTestCase
{

    /**
     * @dataProvider textInput
     */
    public function testProcess(
        string $definition,
        string $input,
        string $expectedOutput
    ) {
        $sut = new TextProcessor(__DIR__);
        $definition = new Definition(
            <<<MATCH
[embed]:# ({$definition})
```php
// existing code
```
MATCH
            ,
            $definition,
            ''
        );
        $result = $sut->process($definition, $input);
        $this->assertSame($expectedOutput, $result);
    }

    public function textInput()
    {
        $embedmePhp = file_get_contents(__DIR__.'/files/embedme.php');
        $definition = 'path: ./files/embedme.php';
        yield 'simple' => [
            $definition,
            <<<MARKDOWN
## Only file
[embed]:# ({$definition})
```php
// existing code
```
## This is left untouched
```php
// existing code
```
MARKDOWN
            ,
            <<<MARKDOWN
## Only file
[embed]:# ($definition)
```php
{$embedmePhp}
```
## This is left untouched
```php
// existing code
```
MARKDOWN
            ,
        ];
        $definition = 'path: ./files/embedme.php, lang: php, match: "function.*}"';

        yield 'with pattern' => [
            $definition,
            <<<MARKDOWN
## Only file
[embed]:# ({$definition})
```php
// existing code
```
## This is left untouched
```php
// existing code
```
MARKDOWN
            ,
            <<<MARKDOWN
## Only file
[embed]:# ({$definition})
```php
function foo(){

}
```
## This is left untouched
```php
// existing code
```
MARKDOWN
            ,
        ];
    }
}
