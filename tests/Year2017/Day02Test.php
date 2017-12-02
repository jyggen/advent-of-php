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
use Boo\AdventOfCode\Year2017\Day02;

class Day02Test extends AbstractTestCase
{
    public function partOneProvider(): array
    {
        return [
            [new Day02("5 1 9 5\n7 5 3\n2 4 6 8"), 18],
            [new Day02($this->loadInputFile(2017, 2)), 48357],
        ];
    }

    public function partTwoProvider(): array
    {
        return [
            [new Day02("5 9 2 8\n9 4 7 3\n3 8 6 5"), 9],
            [new Day02($this->loadInputFile(2017, 2)), 351],
        ];
    }
}
