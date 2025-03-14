<?php

declare(strict_types=1);

namespace Scheel\EditorLinks;

use function array_key_exists;
use function count;
use function getenv;
use function is_string;

function editorLink(string $file, int|string $line = ''): string
{
    $editors = [
        'sublime' => 'subl://open?url=file://%file&line=%line',
        'textmate' => 'txmt://open?url=file://%file&line=%line',
        'emacs' => 'emacs://open?url=file://%file&line=%line',
        'macvim' => 'mvim://open/?url=file://%file&line=%line',
        'phpstorm' => 'phpstorm://open?file=%file&line=%line',
        'idea' => 'idea://open?file=%file&line=%line',
        'vscode' => 'vscode://file/%file:%line',
        'vscode-insiders' => 'vscode-insiders://file/%file:%line',
        'vscode-remote' => 'vscode://vscode-remote/%file:%line',
        'vscode-insiders-remote' => 'vscode-insiders://vscode-remote/%file:%line',
        'vscodium' => 'vscodium://file/%file:%line',
        'nova' => 'nova://core/open/file?filename=%file&line=%line',
        'xdebug' => 'xdebug://%file@%line',
        'atom' => 'atom://core/open/file?filename=%file&line=%line',
        'espresso' => 'x-espresso://open?filepath=%file&lines=%line',
        'netbeans' => 'netbeans://open/?f=%file:%line',
    ];
    $editor = getenv('EDITOR_LINK_EDITOR');
    if (! is_string($editor) || ! array_key_exists($editor, $editors)) {
        $editor = 'phpstorm';
    }
    $format = getenv('EDITOR_LINK_FORMAT');
    if ($format === false || $format === '') {
        $format = $editors[$editor];
    }

    if ($mapping = getenv('EDITOR_LINK_MAPPING')) {
        $paths = explode(':', $mapping);
        if (count($paths) === 2 && $paths[0] !== '' && $paths[1] !== '') {
            $file = str_replace($paths[0], $paths[1], $file);
        }
    }

    return str_replace(['%file', '%line'], [$file, (string) $line], $format);
}
