<?php

declare(strict_types=1);

namespace Noem\Composer;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use Symfony\Component\Yaml\Yaml;

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

    private string $schema;

    public function __construct(
        public string $fullMatch,
        public string $definition,
        public string $existing
    ) {
        $this->schema = <<<'JSON'
{
    "type": "object",
    "required": [
        "path"
    ],
    "propertiesroperties": {
        "path": {
             "type": "string"
        },
        "lang": {
             "type": "string"
        },
        "match": {
             "type": "string"
        }
    }
}
JSON;

        $config = Yaml::parse('{'.$this->definition.'}');
        $validator = new Validator();
        $validator->validate(
            $config,
            json_decode($this->schema),
            Constraint::CHECK_MODE_TYPE_CAST | Constraint::CHECK_MODE_EXCEPTIONS

        );
        $this->file = $config['path'];
        $this->language = $config['lang'] ?? $this->determineLanguage($this->file);
        $pattern = $config['match'] ?? '^.*$';
        $this->pattern = "\034{$pattern}\034";
    }

    private function determineLanguage(string $file): string
    {
        $segments = pathinfo($file);
        $extensionMap = [
            'md' => 'markdown',
        ];
        $ext = $segments['extension'] ?? '';
        if (!isset($extensionMap[$ext])) {
            return $ext;
        }

        return $extensionMap[$ext];
    }
}
