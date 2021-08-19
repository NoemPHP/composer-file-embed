# Composer File Embed

A composer plugin that allows embedding files as code snippets in your markdown docs

## Installation

Install this package via composer:

`composer require noem/composer-file-embed`

## Usage

The plugin parses Marddown's ["hidden link syntax"](https://stackoverflow.com/a/20885980) which can otherwise used for
comments, in a custom format. This allows us to define embeds without these definitions showing up in the generated
output. The format is as follows:

```markdown
[embed]:# (path: filepathOrURL, lang: language, match: '[a-zA-Z]')
```

The config inside the parentheses is actually an inline YAML string, so commas and spaces are important. Don't forget to
quote your config when encessary. Only the `path` is required.

|Key|Type|Required|Example|Comment  |
|---|---|---|---|---|
|path|`string` | yes | `./src/MyClass.php`| Path or URL to the text you want to embed |
|lang|`string`| no | `php` | Specify the language in case in it cannot be (correctly) identified |
|match|`string`| no | `class.*}` | Include only the matching parts of the specified file |

[Check out the Examples page](https://noemphp.github.io/composer-file-embed/Examples/) for more detailed examples and
use-cases.

After you made changes to your documents, use the new CLI command to process all `*.md` files in the current directory.
It will recurse into subdirectories, but exclude the `vendor/` folder.

In your project directory, run:

```shell
composer embed-files
```

## Thanks

* @campoy for [campoy/embed](https://github.com/campoy/embed) which was a huge inspiration.
