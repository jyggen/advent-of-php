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

namespace Boo\AdventOfCode\Tests\Year2015;

use Boo\AdventOfCode\Tests\AbstractTestCase;
use Boo\AdventOfCode\Year2015\Day01;

class Day01Test extends AbstractTestCase
{
    public function partOneProvider(): array
    {
        return [
            [new Day01('(())'), 0],
            [new Day01('()()'), 0],
            [new Day01('((('), 3],
            [new Day01('(()(()('), 3],
            [new Day01('))((((('), 3],
            [new Day01('())'), -1],
            [new Day01('))('), -1],
            [new Day01(')))'), -3],
            [new Day01(')())())'), -3],
            [new Day01($this->loadInputFile(2015, 1)), 232],
        ];
    }

    public function partTwoProvider(): array
    {
        return [
            [new Day01(')'), 1],
            [new Day01('()())'), 5],
            [new Day01($this->loadInputFile(2015, 1)), 1783],
        ];
    }
}
