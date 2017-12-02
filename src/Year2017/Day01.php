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

final class Day01 implements DayInterface
{
    private const HALFWAY_AROUND = 2;

    /**
     * @var string[]
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = \str_split($input);
    }

    public function solvePartOne(): int
    {
        return $this->solve(1);
    }

    public function solvePartTwo(): int
    {
        return $this->solve((int) (\count($this->input) / self::HALFWAY_AROUND));
    }

    private function solve(int $offset): int
    {
        $result = 0;
        $numOfIndexes = \count($this->input);

        foreach ($this->input as $key => $value) {
            $index = $key + $offset;

            if ($index >= $numOfIndexes) {
                $index -= $numOfIndexes;
            }

            if ($value === $this->input[$index]) {
                $result += $value;
            }
        }

        return $result;
    }
}
