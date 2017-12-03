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

namespace Boo\AdventOfCode\Year2016;

use Boo\AdventOfCode\DayInterface;

final class Day24 implements DayInterface
{
    /**
     * @var string[][]
     */
    private $input;

    /**
     * @var mixed[][]
     */
    private $queue;

    /**
     * @var int
     */
    private $startX;

    /**
     * @var int
     */
    private $startY;

    /**
     * @var int[]
     */
    private $stateCache = [];

    public function __construct(string $input)
    {
        $this->input = \array_map(function (string $row): array {
            return \str_split($row);
        }, \explode("\n", $input));

        foreach ($this->input as $y => $columns) {
            foreach ($columns as $x => $column) {
                if ('0' === $column) {
                    $this->startX = $x;
                    $this->startY = $y;

                    break 2;
                }
            }
        }
    }

    private function setUp(): void
    {
        $rows = $this->input;
        $rows[$this->startY][$this->startX] = '.';
        $remaining = [];

        foreach ($rows as $y => $columns) {
            foreach ($columns as $x => $column) {
                if (true === \is_numeric($column)) {
                    $rows[$y][$x] = '.';
                    $remaining[$y][$x] = null;

                    continue;
                }

                if ('.' === $column) {
                    $rows[$y][$x] = 'o';
                }
            }
        }

        $this->stateCache = [];
        $this->queue = [[
            'state' => $rows,
            'y' => $this->startY,
            'x' => $this->startX,
            'remaining' => $remaining,
            'step' => 0,
        ]];
    }

    public function solvePartOne(): int
    {
        $this->setUp();

        while (false === empty($this->queue)) {
            $queue = \array_shift($this->queue);
            $remaining = $this->walk(
                $queue['state'],
                $queue['y'],
                $queue['x'],
                $queue['remaining'],
                $queue['step']
            );

            if (true === empty($remaining)) {
                return $queue['step'];
            }
        }

        return -1;
    }

    public function solvePartTwo(): int
    {
        $this->setUp();

        while (false === empty($this->queue)) {
            $queue = \array_shift($this->queue);
            $remaining = $this->walk(
                $queue['state'],
                $queue['y'],
                $queue['x'],
                $queue['remaining'],
                $queue['step']
            );

            if (true === empty($remaining) && $queue['y'] === $this->startY && $queue['x'] === $this->startX) {
                return $queue['step'];
            }
        }

        return -1;
    }

    private function walk(array $rows, int $y, int $x, array $remaining, int $step): array
    {
        $directions = [
            [$y - 1, $x],
            [$y, $x + 1],
            [$y + 1, $x],
            [$y, $x - 1],
        ];

        if ($rows[$y][$x] === '.') {
            $rows[$y][$x] = 'o';

            unset($remaining[$y][$x]);

            if (true === empty($remaining[$y])) {
                unset($remaining[$y]);
            }
        }

        if ($y !== $this->startY || $x !== $this->startX) {
            $nonWalls = 0;

            foreach ($directions as $pos) {
                if ($rows[$pos[0]][$pos[1]] !== '#') {
                    ++$nonWalls;
                }
            }

            if (1 === $nonWalls) {
                $rows[$y][$x] = '#';
            }
        }

        ++$step;

        $stateKey = \md5(\print_r([$y, $x, $remaining], true));

        if (true === isset($this->stateCache[$stateKey]) && $this->stateCache[$stateKey] <= $step) {
            return $remaining;
        }

        $this->stateCache[$stateKey] = $step;

        foreach ($directions as $pos) {
            if (false === isset($rows[$pos[0]][$pos[1]]) || $rows[$pos[0]][$pos[1]] === '#') {
                continue;
            }

            $stateKey = \md5(\print_r([$pos[0], $pos[1], $remaining], true));

            if (true === isset($this->stateCache[$stateKey]) && $this->stateCache[$stateKey] <= $step) {
                continue;
            }

            $this->queue[] = [
                'state' => $rows,
                'y' => $pos[0],
                'x' => $pos[1],
                'remaining' => $remaining,
                'step' => $step,
            ];
        }

        return $remaining;
    }
}
