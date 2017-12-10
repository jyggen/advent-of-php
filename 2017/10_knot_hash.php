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

function knot_hash(array $lengths, int $rounds): array
{
    $list = range(0, 255);
    $listSize = count($list);
    $current = 0;
    $skipSize = 0;

    for ($round = 0; $round < $rounds; ++$round) {
        foreach ($lengths as $length) {
            $stop = ($current + $length) % $listSize;
            $numbers = [];

            for ($i = $current; $i !== $stop;) {
                $numbers[] = $list[$i];
                $i = ($i + 1) % $listSize;
            }

            $numbers = array_reverse($numbers);

            for ($i = $current; $i !== $stop;) {
                $list[$i] = array_shift($numbers);
                $i = ($i + 1) % $listSize;
            }

            $current = ($current + $length + $skipSize) % $listSize;

            ++$skipSize;
        }
    }

    return $list;
}

$input = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$lengths = explode(',', $input);
$partOne = knot_hash($lengths, 1);

echo $partOne[0] * $partOne[1];
echo PHP_EOL;

$lengths = str_split($input);
$bytes = array_map('ord', $lengths);
$bytes = array_merge($bytes, [17, 31, 73, 47, 23]);
$sparseHash = knot_hash($bytes, 64);
$denseHash = [];

foreach (array_chunk($sparseHash, 16) as $block) {
    $denseHash[] = array_reduce($block, static function (?int $carry, int $value): int {
        if (null === $carry) {
            return $value;
        }

        return $carry ^ $value;
    });
}

$denseHash = implode('', array_map(static function (int $decimal): string {
    return str_pad(dechex($decimal), 2, '0', STR_PAD_LEFT);
}, $denseHash));

echo $denseHash.PHP_EOL;

__halt_compiler();
189,1,111,246,254,2,0,120,215,93,255,50,84,15,94,62
