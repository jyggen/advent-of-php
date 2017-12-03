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

namespace Boo\AdventOfCode\Year2017;

use Boo\AdventOfCode\DayInterface;

final class Day03 implements DayInterface
{
    private const START = 2;

    /**
     * @var string
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function solvePartOne(): int
    {
        $spiral = [];
        $spiral[0][0] = 1;
        $direction = 'r';
        $x = 0;
        $y = 0;

        for ($i = self::START; $i <= $this->input; ++$i) {
            switch ($direction) {
                case 'u':
                    --$y;

                    if (false === isset($spiral[$y][$x - 1])) {
                        $direction = 'l';
                    }
                    break;
                case 'r':
                    ++$x;

                    if (false === isset($spiral[$y - 1][$x])) {
                        $direction = 'u';
                    }
                    break;
                case 'd':
                    ++$y;

                    if (false === isset($spiral[$y][$x + 1])) {
                        $direction = 'r';
                    }
                    break;
                case 'l':
                    --$x;

                    if (false === isset($spiral[$y + 1][$x])) {
                        $direction = 'd';
                    }
                    break;
            }

            $spiral[$y][$x] = $i;
        }

        return \abs($x) + \abs($y);
    }

    public function solvePartTwo(): int
    {
        $spiral = [];
        $spiral[0][0] = 1;
        $direction = 'r';
        $x = 0;
        $y = 0;
        $i = 1;

        while ($i < $this->input) {
            switch ($direction) {
                case 'u':
                    --$y;

                    if (false === isset($spiral[$y][$x - 1])) {
                        $direction = 'l';
                    }
                    break;
                case 'r':
                    ++$x;

                    if (false === isset($spiral[$y - 1][$x])) {
                        $direction = 'u';
                    }
                    break;
                case 'd':
                    ++$y;

                    if (false === isset($spiral[$y][$x + 1])) {
                        $direction = 'r';
                    }
                    break;
                case 'l':
                    --$x;

                    if (false === isset($spiral[$y + 1][$x])) {
                        $direction = 'd';
                    }
                    break;
            }

            $i = 0;
            $i += $spiral[$y][$x - 1] ?? 0;
            $i += $spiral[$y - 1][$x - 1] ?? 0;
            $i += $spiral[$y - 1][$x] ?? 0;
            $i += $spiral[$y - 1][$x + 1] ?? 0;
            $i += $spiral[$y][$x + 1] ?? 0;
            $i += $spiral[$y + 1][$x + 1] ?? 0;
            $i += $spiral[$y + 1][$x] ?? 0;
            $i += $spiral[$y + 1][$x - 1] ?? 0;
            $spiral[$y][$x] = $i;
        }

        return $i;
    }
}
