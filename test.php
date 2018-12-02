<?php

declare(strict_types=1);

/*
 * This file is part of boo/advent-of-php.
 *
 * (c) Jonas Stendahl <jonas@stendahl.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once __DIR__.'/vendor/autoload.php';

use JakubOnderka\PhpConsoleColor\ConsoleColor;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;

$year = $argv[1] ?? null;
$day = $argv[2] ?? null;

if (null !== $day) {
    $day = str_pad($day, 2, '0', STR_PAD_LEFT);
}

$colors = new ConsoleColor();
$tests = json_decode(file_get_contents(__DIR__.'/test.json'), true);

if (JSON_ERROR_NONE !== json_last_error()) {
    echo 'Unable to parse JSON: '.json_last_error_msg();
    exit(1);
}

$pathRegex = '/^([\d]{4})\/([\d]{2}).*\.php$/';
$finder = new Finder();
$files = [];

$finder->in(__DIR__)->path($pathRegex)->files()->sortByName();

/** @var SplFileInfo $file */
foreach ($finder as $file) {
    if (1 !== preg_match($pathRegex, $file->getRelativePathname(), $match)) {
        continue;
    }

    if (null !== $year && $match[1] !== $year) {
        continue;
    }

    if (null !== $day && $match[2] !== $day) {
        continue;
    }

    $files[$match[1]][$match[2]] = $file;
}

$testFunc = static function (
    SplFileInfo $file,
    int $part,
    ?string $input,
    ?string $expected,
    string $actual
) use ($colors): void {
    if (null === $expected || $expected === $actual) {
        return;
    }

    echo vsprintf("[%s] %s (part %u)\n\nInput: %s\n\nExpected: %s\nActual:   %s\n", [
        $colors->apply('red', 'FAIL'),
        $file->getRelativePathname(),
        $part,
        str_replace("\n", $colors->apply('cyan', '\n'), $input),
        $colors->apply('green', $expected),
        $colors->apply('red', $actual),
    ]);

    exit(1);
};

foreach ($files as $year => $days) {
    foreach ($days as $day => $file) {
        foreach ($tests[$year][$day] as $test) {
            $command = [
                'php',
                $file->getPathname(),
            ];

            if (null !== $test['input']) {
                $command[] = $test['input'];
            }

            $process = new Process($command);

            $process->mustRun();

            $output = $process->getOutput();
            $outputLines = explode(PHP_EOL, trim($process->getOutput()));

            if (2 !== count($outputLines)) {
                echo vsprintf("[%s] %s\n\nInput:  %s\nOutput: %s\n", [
                    $colors->apply('red', 'FAIL'),
                    $file->getRelativePathname(),
                    str_replace("\n", $colors->apply('cyan', '\n'), $test['input']),
                    str_replace("\n", $colors->apply('cyan', '\n'), $output),
                ]);

                exit(1);
            }

            $testFunc($file, 1, $test['input'], $test['expected'][0], $outputLines[0]);
            $testFunc($file, 2, $test['input'], $test['expected'][1], $outputLines[1]);

            echo vsprintf("[%s] %s\n", [
                $colors->apply('green', 'PASS'),
                $file->getRelativePathname(),
            ]);
        }
    }
}
