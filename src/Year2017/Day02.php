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
use drupol\phpermutations\Generators\Permutations;

final class Day02 implements DayInterface
{
    private const PERMUTATIONS = 2;

    /**
     * @var int[][]
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = \array_map(function (string $row): array {
            \preg_match_all('([\d]+)', $row, $matches);

            return \array_map('\intval', $matches[0]);
        }, \explode("\n", $input));
    }

    public function solvePartOne(): int
    {
        return \array_reduce($this->input, function (int $carry, array $row): int {
            return $carry + \max($row) - \min($row);
        }, 0);
    }

    public function solvePartTwo(): int
    {
        return \array_reduce($this->input, function (int $carry, array $row): int {
            $permutations = new Permutations($row, self::PERMUTATIONS);

            foreach ($permutations->generator() as $permutation) {
                if ($permutation[0] % $permutation[1] === 0) {
                    return $carry + $permutation[0] / $permutation[1];
                }
            }

            return $carry;
        }, 0);
    }
}
