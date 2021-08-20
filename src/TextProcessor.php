<?php

declare(strict_types=1);

namespace Noem\Composer;

class TextProcessor
{

    private string $baseDir;

    public function __construct(string $baseDir)
    {
        $this->baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function process(Definition $definition, string $content): string
    {
        return preg_replace($this->createSearch($definition), $this->createReplacement($definition), $content);
    }

    private function createSearch(Definition $definition): string
    {
        return sprintf(
            '/\[embed]:\s*?(#|(<>))\s*?[\("]%s[\)"]\n+(```.*?```)?/ms',
            preg_quote($definition->definition, '/')
        );
    }

    private function createReplacement(Definition $definition): string
    {
        $fileName = $this->baseDir . $definition->file;
        if (!is_readable($fileName)) {
            throw new \RuntimeException("{$fileName} could not be found for embedding");
        }
        $embedContent = file_get_contents($fileName);
        $matches = [];
        preg_match($definition->pattern . 'ms', $embedContent, $matches);
        $embedContent = $matches[0];

        return <<<MARKDOWN
[embed]:# ({$definition->definition})
```{$definition->language}
{$embedContent}
```
MARKDOWN;
    }
}
