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

require_once dirname(__DIR__).'/vendor/autoload.php';

define('UP', 0);
define('RIGHT', 1);
define('DOWN', 2);
define('LEFT', 3);

function solve_part_one(array $grid): int
{
    $direction = UP;
    $y = (int) floor(count($grid) / 2);
    $x = $y;
    $infected = 0;

    for ($i = 0; $i < 10000; ++$i) {
        if (false === isset($grid[$y][$x])) {
            $grid[$y][$x] = '.';
        }

        $direction = '#' === $grid[$y][$x]
            ? $direction + 1
            : $direction - 1;

        if ($direction < UP) {
            $direction = LEFT;
        } elseif ($direction > LEFT) {
            $direction = UP;
        }

        $grid[$y][$x] = '#' === $grid[$y][$x]
            ? '.'
            : '#';

        if ('#' === $grid[$y][$x]) {
            ++$infected;
        }

        switch ($direction) {
            case UP:
                --$y;
                break;
            case RIGHT:
                ++$x;
                break;
            case DOWN:
                ++$y;
                break;
            case LEFT:
                --$x;
                break;
        }
    }

    return $infected;
}

function solve_part_two(array $grid): int
{
    $direction = UP;
    $y = (int) floor(count($grid) / 2);
    $x = $y;
    $infected = 0;

    for ($i = 0; $i < 10000000; ++$i) {
        if (false === isset($grid[$y][$x])) {
            $grid[$y][$x] = '.';
        }

        switch ($grid[$y][$x]) {
            case '#':
                ++$direction;
                $grid[$y][$x] = 'F';
                break;
            case '.':
                --$direction;
                $grid[$y][$x] = 'W';
                break;
            case 'W':
                $grid[$y][$x] = '#';
                break;
            case 'F':
                $direction += 2;
                $grid[$y][$x] = '.';
                break;
        }

        if ($direction < UP) {
            $direction += 4;
        } elseif ($direction > LEFT) {
            $direction -= 4;
        }

        if ('#' === $grid[$y][$x]) {
            ++$infected;
        }

        switch ($direction) {
            case UP:
                --$y;
                break;
            case RIGHT:
                ++$x;
                break;
            case DOWN:
                ++$y;
                break;
            case LEFT:
                --$x;
                break;
        }
    }

    return $infected;
}

$input = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$lines = explode("\n", $input);
$grid = [];

foreach ($lines as $index => $line) {
    $grid[$index] = str_split($line);
}

echo solve_part_one($grid).PHP_EOL;
echo solve_part_two($grid).PHP_EOL;

__halt_compiler();
...###.#.#.##...##.#..##.
.#...#..##.#.#..##.#.####
#..#.#...######.....#####
.###.#####.#...#.##.##...
.#.#.##......#....#.#.#..
....##.##.#..##.#...#....
#...###...#.###.#.#......
..#..#.....##..####..##.#
#...#..####.#####...#.##.
###.#.#..#..#...##.#..#..
.....##..###.##.#.....#..
#.....#...#.###.##.##...#
.#.##.##.##.#.#####.##...
##.#.###..#.####....#.#..
#.##.#...#.###.#.####..##
#.##..#..##..#.##.####.##
#.##.#....###.#.#......#.
.##..#.##..###.#..#...###
#..#.#.#####.....#.#.#...
.#####..###.#.#.##..#....
###..#..#..##...#.#.##...
..##....##.####.....#.#.#
..###.##...#..#.#####.###
####.########.#.#..##.#.#
#####.#..##...####.#..#..
