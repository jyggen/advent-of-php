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
use Boo\AdventOfCode\Year2017\Day03;

class Day03Test extends AbstractTestCase
{
    public function partOneProvider(): array
    {
        return [
            [new Day03('1'), 0],
            [new Day03('12'), 3],
            [new Day03('23'), 2],
            [new Day03('1024'), 31],
            [new Day03($this->loadInputFile(2017, 3)), 371],
        ];
    }

    public function partTwoProvider(): array
    {
        return [
            [new Day03($this->loadInputFile(2017, 3)), 369601],
        ];
    }
}
