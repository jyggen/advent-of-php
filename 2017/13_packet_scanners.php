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

final class Firewall
{
    /**
     * @var array
     */
    private $detectedAt = [];

    /**
     * @var array
     */
    private $firewall;

    /**
     * @var int
     */
    private $length;

    public function __construct(string $input)
    {
        $layout = explode("\n", $input);

        end($layout);

        $length = (int) explode(': ', current($layout))[0] + 1;
        $firewall = array_fill(0, $length, null);

        foreach ($layout as $layer) {
            [$layer, $depth] = explode(': ', $layer);
            $layer = (int) $layer;
            $depth = (int) $depth;

            $firewall[$layer] = $depth;
        }

        $this->firewall = $firewall;
        $this->length = count($firewall) - 1;
    }

    public function getSeverity(): int
    {
        return array_reduce($this->detectedAt, function (int $carry, int $layer): int {
            return $carry + $layer * $this->firewall[$layer];
        }, 0);
    }

    public function sendPackage(bool $allowDetection = true, int $delay = 0): bool
    {
        $current = -1;

        while ($current < $this->length) {
            ++$current;

            if (null === $this->firewall[$current]) {
                continue;
            }

            $scannerPosition = $current + $delay;
            $scannerPosition %= $this->firewall[$current] * 2 - 2;

            if (0 === $scannerPosition) {
                $this->detectedAt[] = $current;

                if (false === $allowDetection) {
                    return false;
                }
            }
        }

        return true;
    }
}

$input = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$firewall = new Firewall($input);

$firewall->sendPackage();

echo $firewall->getSeverity().PHP_EOL;

$sleep = 0;

while (true !== $firewall->sendPackage(false, $sleep)) {
    ++$sleep;
}

echo $sleep.PHP_EOL;

__halt_compiler();
0: 3
1: 2
2: 9
4: 4
6: 4
8: 6
10: 6
12: 8
14: 5
16: 6
18: 8
20: 8
22: 8
24: 6
26: 12
28: 12
30: 8
32: 10
34: 12
36: 12
38: 10
40: 12
42: 12
44: 12
46: 12
48: 14
50: 14
52: 8
54: 12
56: 14
58: 14
60: 14
64: 14
66: 14
68: 14
70: 14
72: 14
74: 12
76: 18
78: 14
80: 14
86: 18
88: 18
94: 20
98: 18
