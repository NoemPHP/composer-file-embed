# Composer File Embed

A composer plugin that allows embedding files as code snippets in your markdown docs

## Installation

Install this package via composer:

`composer require noem/composer-file-embed`

## Usage

The plugin parses Markdown's ["hidden link syntax"](https://stackoverflow.com/a/20885980) which can otherwise used for
comments, in a custom format. This allows us to define embeds without these definitions showing up in the generated
output. The following formats are all valid, so in case your markdown processor trips over one, you can try a different
format:

```markdown
[embed]:# (path: filepathOrURL, lang: language, match: '[a-zA-Z]')

[embed]:<> (path: filepathOrURL, lang: language, match: '[a-zA-Z]')

[embed]:# "path: filepathOrURL, lang: language, match: '[a-zA-Z]'"
```

The config inside the parentheses is actually an inline YAML string, so commas and spaces are important. Don't forget to
quote your config when encessary. Only the `path` is required.

|Key|Type|Required|Example|Comment  |
|---|---|---|---|---|
|path|`string` | yes | `./src/MyClass.php`| Path or URL to the text you want to embed |
|lang|`string`| no | `php` | Specify the language in case in it cannot be (correctly) identified |
|match|`string`| no | `class.*}` | Include only the matching parts of the specified file. Default: `^.*$` |

Since only the `path` is required, you can simply do

```markdown
[embed]:# (path: path/to/file.php)
```

...to embed a full file.

[Check out the Examples page](https://noemphp.github.io/composer-file-embed/Examples/) for more detailed examples and
use-cases.

After you made changes to your documents, use the new CLI command to process all `*.md` files in the current directory.
It will recurse into subdirectories, but exclude the `vendor/` folder.

In your project directory, run:

```shell
composer embed-files
```

## Notes

**When using Jekyll / GH-Pages**, the comment markup can break if you use quotes in your YAML. Try a different format
then. For example, if you need to pass a single-quoted regex pattern, the use of double quotes in the comment is known
to work:

```markdown
[embed]:# "path: ./foo.md, match: '##\sThanks.*$'"
```

## Thanks

* @campoy for [campoy/embed](https://github.com/campoy/embed) which was a huge inspiration.
