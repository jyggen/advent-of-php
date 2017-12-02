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

namespace Boo\AdventOfCode\Tests\Year2017;

use Boo\AdventOfCode\Tests\AbstractTestCase;
use Boo\AdventOfCode\Year2017\Day01;

class Day01Test extends AbstractTestCase
{
    public function partOneProvider(): array
    {
        return [
            [new Day01('1122'), 3],
            [new Day01('1111'), 4],
            [new Day01('1234'), 0],
            [new Day01($this->loadInputFile(2017, 1)), 1253],
        ];
    }

    public function partTwoProvider(): array
    {
        return [
            [new Day01('1212'), 6],
            [new Day01('1221'), 0],
            [new Day01('123425'), 4],
            [new Day01('123123'), 12],
            [new Day01('12131415'), 4],
            [new Day01($this->loadInputFile(2017, 1)), 1278],
        ];
    }
}
