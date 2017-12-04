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

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_last_error_msg();
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

foreach ($files as $year => $days) {
    foreach ($days as $day => $file) {
        if (false === isset($tests[$year][$day])) {
            continue;
        }

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

            $output = explode(PHP_EOL, trim($process->getOutput()));

            if ($test['expected'][0] !== null && $test['expected'][0] !== $output[0]) {
                echo vsprintf("[%s] %s (part 1)\n\nExpected: %s\nActual:   %s\n", [
                    $colors->apply('red', 'FAIL'),
                    $file->getRelativePathname(),
                    $test['expected'][0],
                    $output[0],
                ]);

                exit(1);
            }

            if ($test['expected'][1] !== null && $test['expected'][1] !== $output[1]) {
                echo vsprintf("[%s] %s (part 2)\n\nExpected: %s\nActual:   %s\n", [
                    $colors->apply('red', 'FAIL'),
                    $file->getRelativePathname(),
                    $test['expected'][1],
                    $output[1],
                ]);

                exit(1);
            }

            echo vsprintf("[%s] %s\n", [
                $colors->apply('green', 'PASS'),
                $file->getRelativePathname(),
            ]);
        }
    }
}
