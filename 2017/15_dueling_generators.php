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

preg_match_all('([\d]+)', $input, $matches);

$factors = [
    16807,
    48271,
];

$multiples = [
    4,
    8,
];

$generators = [
    (int) $matches[0][0],
    (int) $matches[0][1],
];

$score = 0;

for ($i = 0; $i < 40000000; ++$i) {
    foreach ($generators as $key => $value) {
        $generators[$key] = ($value * $factors[$key]) % 2147483647;
    }

    if (mb_substr(decbin($generators[0]), -16, null, '8bit') === mb_substr(decbin($generators[1]), -16, null, '8bit')) {
        ++$score;
    }
}

echo $score.PHP_EOL;

$generators = [
    (int) $matches[0][0],
    (int) $matches[0][1],
];

$score = 0;

for ($i = 0; $i < 5000000; ++$i) {
    foreach (array_keys($generators) as $key) {
        do {
            $generators[$key] = ($generators[$key] * $factors[$key]) % 2147483647;
        } while ($generators[$key] % $multiples[$key] !== 0);
    }

    if (mb_substr(decbin($generators[0]), -16, null, '8bit') === mb_substr(decbin($generators[1]), -16, null, '8bit')) {
        ++$score;
    }
}

echo $score.PHP_EOL;

__halt_compiler();
Generator A starts with 634
Generator B starts with 301
