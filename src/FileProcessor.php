<?php

declare(strict_types=1);

namespace Noem\Composer;

class FileProcessor
{

    public function process(string $inputFile, string $outputFile, Definition ...$definitions)
    {
        $contents = file_get_contents($inputFile);
        $processor = new TextProcessor(dirname($inputFile));
        foreach ($definitions as $definition) {
            $contents = $processor->process($definition, $contents);
        }
        file_put_contents($outputFile, $contents);
    }
}
