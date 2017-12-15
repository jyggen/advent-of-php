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

$input = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);

function find_hash(string $key, int $zeros): int
{
    $number = -1;
    $zeroStr = str_repeat('0', $zeros);

    while (0 !== strpos(md5($key.$number), $zeroStr)) {
        ++$number;
    }

    return $number;
}

echo find_hash($input, 5).PHP_EOL;
echo find_hash($input, 6).PHP_EOL;

__halt_compiler();
iwrupvqb
