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

function find_strongest_bridge(array $components, array $bridge): array
{
    $last = end($bridge);
    $bridges = [
        count($bridge) => array_sum($bridge),
    ];

    foreach ($components as $index => $component) {
        if ($component[0] === $last) {
            $new = $components;
            unset($new[$index]);
            $bridges = merge_bridges($bridges, find_strongest_bridge($new, array_merge($bridge, [
                $component[0],
                $component[1],
            ])));
        } elseif ($component[1] === $last) {
            $new = $components;
            unset($new[$index]);
            $bridges = merge_bridges($bridges, find_strongest_bridge($new, array_merge($bridge, [
                $component[1],
                $component[0],
            ])));
        }
    }

    return $bridges;
}

function merge_bridges(array $bridges, array $available): array
{
    foreach ($available as $count => $strength) {
        if (false === array_key_exists($count, $bridges)) {
            $bridges[$count] = $strength;
            continue;
        }

        if ($bridges[$count] < $available[$count]) {
            $bridges[$count] = $available[$count];
        }
    }

    return $bridges;
}

$components = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$components = explode("\n", $components);
$components = array_map(static function (string $component): array {
    return array_map('\intval', explode('/', $component));
}, $components);

$bridges = find_strongest_bridge($components, [0]);

echo max($bridges).PHP_EOL;

ksort($bridges);

echo end($bridges).PHP_EOL;

__halt_compiler();
50/41
19/43
17/50
32/32
22/44
9/39
49/49
50/39
49/10
37/28
33/44
14/14
14/40
8/40
10/25
38/26
23/6
4/16
49/25
6/39
0/50
19/36
37/37
42/26
17/0
24/4
0/36
6/9
41/3
13/3
49/21
19/34
16/46
22/33
11/6
22/26
16/40
27/21
31/46
13/2
24/7
37/45
49/2
32/11
3/10
32/49
36/21
47/47
43/43
27/19
14/22
13/43
29/0
33/36
2/6
