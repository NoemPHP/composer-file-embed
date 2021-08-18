<?php

declare(strict_types=1);

namespace Noem\Composer;

class Definition
{

    /**
     * @readonly
     */
    public string $file;

    /**
     * @readonly
     */
    public string $language;

    /**
     * @readonly
     */
    public string $pattern;

    public function __construct(
        public string $fullMatch,
        public string $definition,
        public string $existing
    ) {
        $definitionSegments = explode(' ', preg_replace('/\s+/', ' ', $this->definition));
        $this->file = $definitionSegments[0];
        $this->language = $definitionSegments[1] ?? $this->determineLanguage($this->file);
        $pattern = $definitionSegments[2] ?? '^.*$';
        $this->pattern = "\034{$pattern}\034";
    }

    private function determineLanguage(string $file): string
    {
        $segments = pathinfo($file);
        $extensionMap = [
            'md' => 'markdown',
        ];
        $ext = $segments['extension'];
        if (!isset($extensionMap[$ext])) {
            return $ext;
        }

        return $extensionMap[$ext];
    }
}
