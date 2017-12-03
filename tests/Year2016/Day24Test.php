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

namespace Boo\AdventOfCode\Tests\Year2016;

use Boo\AdventOfCode\Tests\AbstractTestCase;
use Boo\AdventOfCode\Year2016\Day24;

class Day24Test extends AbstractTestCase
{
    public function partOneProvider(): array
    {
        return [
            [new Day24("###########\n#0.1.....2#\n#.#######.#\n#4.......3#\n###########"), 14],
            [new Day24($this->loadInputFile(2016, 24)), 448],
        ];
    }

    public function partTwoProvider(): array
    {
        return [
            [new Day24($this->loadInputFile(2016, 24)), 672],
        ];
    }
}
