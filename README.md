<p align="center">
    <p align="center">
        <a href="https://github.com/mortenscheel/editor-links/actions"><img alt="GitHub Workflow Status (master)" src="https://github.com/mortenscheel/editor-links/actions/workflows/tests.yml/badge.svg"></a>
        <a href="https://packagist.org/packages/mortenscheel/editor-links"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/mortenscheel/editor-links"></a>
        <a href="https://packagist.org/packages/mortenscheel/editor-links"><img alt="Latest Version" src="https://img.shields.io/packagist/v/mortenscheel/editor-links"></a>
        <a href="https://packagist.org/packages/mortenscheel/editor-links"><img alt="License" src="https://img.shields.io/packagist/l/mortenscheel/editor-links"></a>
    </p>
</p>

# EditorLinks

A lightweight PHP package that generates clickable links to open files directly in your preferred code editor.

## Installation

You can install the package via composer:

```bash
composer require mortenscheel/editor-links
```

## Usage

```php
<?php

use function Scheel\EditorLinks\editorLink;

// Generate a link to open a file at a specific line in your editor
$link = editorLink('/path/to/your/file.php', 42);

// Output: phpstorm://open?file=/path/to/your/file.php&line=42
echo $link;
```

## Supported Editors

EditorLinks supports the following editors out of the box:

- `phpstorm` (default)
- `sublime`
- `textmate`
- `emacs`
- `macvim`
- `idea`
- `vscode`
- `vscode-insiders`
- `vscode-remote`
- `vscode-insiders-remote`
- `vscodium`
- `nova`
- `xdebug`
- `atom`
- `espresso`
- `netbeans`

## Configuration

### Setting the editor

By default, EditorLinks uses PhpStorm as the target editor. You can change this by setting the `EDITOR_LINK_EDITOR` environment variable:

```bash
# In your .env file or shell environment
EDITOR_LINK_EDITOR=vscode
```
#### Using a custom link format

Alternatively you can provide a custom link format with `%file` and `%line` placeholders:

```bash
EDITOR_LINK_FORMAT=custom-scheme://open?file=%file&line=%line
```

### Path Mapping

If you're working in an environment where file paths need to be transformed (like Docker or WSL), you can set up path mapping using the `EDITOR_LINK_MAPPING` environment variable:

```bash
# Format: localPath:remotePath
EDITOR_LINK_MAPPING=/var/www/html:/Users/username/Projects
```

This will replace `/var/www/html` with `/Users/username/Projects` in file paths.

## Examples

### HTML link to error location

```php
$link = editorLink($exception->getFile(), $exception->getLine());
echo "<a href=\"$link\">Open in editor</a>";
```

### Terminal link in console commands

```php
// In Symfony Console command
$output->writeln("<href=$link>Link label</>");
// In Laravel Artisan commands
$this->output->writeln("<href=$link>Link label</>");
$this->info("<href=$link>Link label</>");
```

## Contributing

Contributions are welcome! If you'd like to add support for another editor or improve the package, please feel free to submit a pull request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [Morten Scheel](https://github.com/mortenscheel)
- [All Contributors](../../contributors)
