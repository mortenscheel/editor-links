<?php

declare(strict_types=1);

use function Scheel\EditorLinks\editorLink;

arch()->preset()->php();
arch()->preset()->security();

beforeEach(function (): void {
    putenv('EDITOR_LINK_EDITOR');
    putenv('EDITOR_LINK_MAPPING');
    putenv('EDITOR_LINK_FORMAT');
});

it('works without environment variables', function (): void {
    expect(editorLink('/project/file.php', 10))
        ->toBe('phpstorm://open?file=/project/file.php&line=10');
});

it('can use valid path mapping', function (): void {
    putenv('EDITOR_LINK_MAPPING=/project:/mapped');
    expect(editorLink('/project/file.php', 10))
        ->toBe('phpstorm://open?file=/mapped/file.php&line=10');
});

it('ignores invalid path mapping', function (): void {
    putenv('EDITOR_LINK_MAPPING=1:2:3');
    expect(editorLink('/project/file.php', 10))
        ->toBe('phpstorm://open?file=/project/file.php&line=10');
});

it('uses fallback if editor is invalid', function (): void {
    putenv('EDITOR_LINK_EDITOR=invalid');
    expect(editorLink('/project/file.php', 10))
        ->toBe('phpstorm://open?file=/project/file.php&line=10');
});

it('can use a custom format', function (): void {
    putenv('EDITOR_LINK_FORMAT=custom-protocol//open/%file:%line');
    expect(editorLink('/project/file.php', 10))
        ->toBe('custom-protocol//open//project/file.php:10');
});

it('can use valid editor', function (string $editor, string $expected): void {
    putenv("EDITOR_LINK_EDITOR=$editor");
    expect(editorLink('/project/file.php', 10))
        ->toBe($expected);
})->with([
    'sublime' => ['sublime', 'subl://open?url=file:///project/file.php&line=10'],
    'textmate' => ['textmate', 'txmt://open?url=file:///project/file.php&line=10'],
    'emacs' => ['emacs', 'emacs://open?url=file:///project/file.php&line=10'],
    'macvim' => ['macvim', 'mvim://open/?url=file:///project/file.php&line=10'],
    'phpstorm' => ['phpstorm', 'phpstorm://open?file=/project/file.php&line=10'],
    'idea' => ['idea', 'idea://open?file=/project/file.php&line=10'],
    'vscode' => ['vscode', 'vscode://file//project/file.php:10'],
    'vscode-insiders' => ['vscode-insiders', 'vscode-insiders://file//project/file.php:10'],
    'vscode-remote' => ['vscode-remote', 'vscode://vscode-remote//project/file.php:10'],
    'vscode-insiders-remote' => ['vscode-insiders-remote', 'vscode-insiders://vscode-remote//project/file.php:10'],
    'vscodium' => ['vscodium', 'vscodium://file//project/file.php:10'],
    'nova' => ['nova', 'nova://core/open/file?filename=/project/file.php&line=10'],
    'xdebug' => ['xdebug', 'xdebug:///project/file.php@10'],
    'atom' => ['atom', 'atom://core/open/file?filename=/project/file.php&line=10'],
    'espresso' => ['espresso', 'x-espresso://open?filepath=/project/file.php&lines=10'],
    'netbeans' => ['netbeans', 'netbeans://open/?f=/project/file.php:10'],
]);
