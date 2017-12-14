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

function add_group_number(array $disk, int $y, int $x, int $groupNumber): array
{
    $directions = [
        [$y - 1, $x],
        [$y, $x + 1],
        [$y + 1, $x],
        [$y, $x - 1],
    ];

    foreach ($directions as $direction) {
        if (false === isset($disk[$direction[0]][$direction[1]]) ||
            false === is_int($disk[$direction[0]][$direction[1]])) {
            continue;
        }

        $groupNumber = $disk[$direction[0]][$direction[1]];
        break;
    }

    $disk[$y][$x] = $groupNumber;

    foreach ($directions as $direction) {
        if (false === isset($disk[$direction[0]][$direction[1]]) || $disk[$direction[0]][$direction[1]] !== true) {
            continue;
        }

        $disk = add_group_number($disk, $direction[0], $direction[1], $groupNumber);
    }

    return $disk;
}

function gmp_convert(string $value, int $from, int $to): string
{
    return gmp_strval(gmp_init($value, $from), $to);
}

function knot_hash(string $string): string
{
    $bytes = str_split($string);
    $bytes = array_map('ord', $bytes);
    $bytes = array_merge($bytes, [17, 31, 73, 47, 23]);
    $list = range(0, 255);
    $listSize = count($list);
    $current = 0;
    $skipSize = 0;

    for ($round = 0; $round < 64; ++$round) {
        foreach ($bytes as $byte) {
            $stop = ($current + $byte) % $listSize;
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

            $current = ($current + $byte + $skipSize) % $listSize;

            ++$skipSize;
        }
    }

    $denseHash = [];

    foreach (array_chunk($list, 16) as $block) {
        $denseHash[] = array_reduce($block, static function (?int $carry, int $value): int {
            if (null === $carry) {
                return $value;
            }

            return $carry ^ $value;
        });
    }

    return implode('', array_map(static function (int $decimal): string {
        return str_pad(dechex($decimal), 2, '0', STR_PAD_LEFT);
    }, $denseHash));
}

$input = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$disk = [];
$used = 0;

for ($y = 0; $y < 128; ++$y) {
    $hash = knot_hash($input.'-'.$y);
    $binary = str_pad(gmp_convert($hash, 16, 2), 128, '0', STR_PAD_LEFT);
    $used += mb_substr_count($binary, '1');

    foreach (str_split($binary) as $x => $value) {
        $disk[$y][$x] = (bool) $value;
    }
}

echo $used.PHP_EOL;

$groups = 0;

for ($y = 0; $y < 128; ++$y) {
    for ($x = 0; $x < 128; ++$x) {
        if ($disk[$y][$x] !== true) {
            continue;
        }

        $disk = add_group_number($disk, $y, $x, $groups + 1);
        $groups = $disk[$y][$x];
    }
}

echo $groups.PHP_EOL;

__halt_compiler();
ffayrhll
