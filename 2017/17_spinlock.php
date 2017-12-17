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

require_once dirname(__DIR__).'/vendor/autoload.php';

function get_last_index(int $iterations, int $steps): int
{
    $index = 0;

    for ($i = 1; $i <= $iterations; ++$i) {
        $index = ($index + $steps) % $i + 1;
    }

    return $index;
}

function get_value_at_index(int $wanted, int $iterations, int $steps): int
{
    $index = get_last_index($iterations, $steps);

    for ($i = $iterations; $i > 0; --$i) {
        $index = abs($index + $i - $steps - 1) % $i;

        if ($index === $wanted) {
            return $i - 1;
        }

        if ($index < $wanted) {
            --$wanted;
        }
    }
}

$steps = (int) read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$wanted = get_last_index(2017, $steps);

echo get_value_at_index($wanted, 2017, $steps).PHP_EOL;
echo get_value_at_index(1, 50000000, $steps).PHP_EOL;

__halt_compiler();
343
