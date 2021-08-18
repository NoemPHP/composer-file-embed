# Composer File Embed

A composer plugin that allows embedding files as code snippets in your markdown docs

## Installation

Install this package via composer:

`composer require noem/composer-file-embed`

## Usage

The plugin parses ["hidden link syntax"](https://stackoverflow.com/a/20885980) in a custom format. This allows us to
define embeds without these definitions showing up in the generated output. The format is as follows:

**Embed a complete file by only specifying the file path**

```markdown
[embedmd]:# (pathOrURL language)
```

The language used for syntax highlighting will be chosen based on the file extension

**Full example - with language and regex pattern**

```markdown
[embedmd]:# (pathOrURL language /match regexp/)
```

Only the part of the file that matches the given pattern will be included

**Embed the full file by omitting the regex pattern**

```markdown
[embedmd]:# (pathOrURL language)
```

After you made changes to your documents, use the new CLI command to process all `*.md` files in the current directory.
It will recurse into subdirectories, but exclude the `vendor/` folder.

In your project directory, run:

```shell
composer embed-files
```

## Thanks

* @campoy for [campoy/embedmd](https://github.com/campoy/embedmd) which was a huge inspiration.
