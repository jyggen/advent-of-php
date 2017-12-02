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

namespace Boo\AdventOfCode\Tests;

use Boo\AdventOfCode\DayInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    abstract public function partOneProvider(): array;

    abstract public function partTwoProvider(): array;

    /**
     * @param DayInterface $day
     * @param mixed        $expected
     *
     * @dataProvider partOneProvider
     */
    public function testSolvePartOne(DayInterface $day, $expected): void
    {
        self::assertSame($expected, $day->solvePartOne());
    }

    /**
     * @param DayInterface $day
     * @param mixed        $expected
     *
     * @dataProvider partTwoProvider
     */
    public function testSolvePartTwo(DayInterface $day, $expected): void
    {
        self::assertSame($expected, $day->solvePartTwo());
    }

    protected function loadInputFile(int $year, int $day): string
    {
        $filename = \vsprintf('%s/resources/inputs/Year%u/Day%02u.txt', [
            \dirname(__DIR__),
            $year,
            $day,
        ]);

        if (false === \file_exists($filename)) {
            throw new \RuntimeException(\sprintf('Unable to read "%s"', $filename));
        }

        return \rtrim(\file_get_contents($filename));
    }
}
