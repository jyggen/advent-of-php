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

namespace Boo\AdventOfCode\Year2015;

use Boo\AdventOfCode\DayInterface;

final class Day01 implements DayInterface
{
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
        $up = 0 - \mb_strlen(\str_replace('(', '', $this->input));
        $down = \mb_strlen(\str_replace(')', '', $this->input));

        return $up + $down;
    }

    public function solvePartTwo(): int
    {
        $floor = 0;

        foreach (\str_split($this->input) as $key => $value) {
            $floor = ('(' === $value) ? $floor + 1 : $floor - 1;

            if ($floor < 0) {
                return $key + 1;
            }
        }

        return -1;
    }
}
