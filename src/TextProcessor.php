<?php

declare(strict_types=1);

namespace Noem\Composer;

class TextProcessor
{

    public function __construct(string $baseDir)
    {
        $this->baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function process(Definition $definition, string $content): string
    {
        return preg_replace($this->createSearch($definition), $this->createReplacement($definition), $content);
    }

    private function createSearch(Definition $definition)
    {
        return sprintf(
            '/\[embedmd]:#\s*\(%s\)\n*(```.*?```)?/ms',
            preg_quote($definition->definition, '/')
        );
    }

    private function createReplacement(Definition $definition): string
    {
        $embedContent = file_get_contents($this->baseDir . $definition->file);
        $matches = [];
        preg_match($definition->pattern . 'ms', $embedContent, $matches);
        $embedContent = $matches[0];
        $result = <<<MARKDOWN
[embedmd]:# ({$definition->definition})
```{$definition->language}
{$embedContent}
```
MARKDOWN;

        return $result;
    }
}
