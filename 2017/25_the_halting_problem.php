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
$lines = explode("\n", $input);

preg_match('/^Begin in state ([A-Z]).$/', array_shift($lines), $match);

$current = $match[1];

preg_match('/^Perform a diagnostic checksum after (\d+) steps.$/', array_shift($lines), $match);

$steps = (int) $match[1];

array_shift($lines);

$states = [];

do {
    preg_match('/^In state ([A-Z]):$/', trim(array_shift($lines)), $match);

    $state = $match[1];

    for ($i = 0; $i < 2; ++$i) {
        preg_match('/^If the current value is (\d):$/', trim(array_shift($lines)), $match);

        $value = (int) $match[1];

        preg_match('/^- Write the value (\d).$/', trim(array_shift($lines)), $match);

        $states[$state][$value]['write'] = (int) $match[1];

        preg_match('/^- Move one slot to the ([a-z]+).$/', trim(array_shift($lines)), $match);

        $states[$state][$value]['move'] = $match[1];

        preg_match('/^- Continue with state ([A-Z]).$/', trim(array_shift($lines)), $match);

        $states[$state][$value]['state'] = $match[1];
    }

    array_shift($lines);
} while (count($lines) > 0);

$tape = [];
$position = 0;
$state = $current;

for ($i = 0; $i < $steps; ++$i) {
    if (false === array_key_exists($position, $tape)) {
        $tape[$position] = 0;
    }

    $value = $tape[$position];
    $tape[$position] = $states[$state][$value]['write'];
    $position += 'left' === $states[$state][$value]['move'] ? -1 : 1;
    $state = $states[$state][$value]['state'];
}

echo array_sum($tape).PHP_EOL;
echo '0'.PHP_EOL;

__halt_compiler();
Begin in state A.
Perform a diagnostic checksum after 12683008 steps.

In state A:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state B.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the left.
    - Continue with state B.

In state B:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state C.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the right.
    - Continue with state E.

In state C:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state E.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the left.
    - Continue with state D.

In state D:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state A.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the left.
    - Continue with state A.

In state E:
  If the current value is 0:
    - Write the value 0.
    - Move one slot to the right.
    - Continue with state A.
  If the current value is 1:
    - Write the value 0.
    - Move one slot to the right.
    - Continue with state F.

In state F:
  If the current value is 0:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state E.
  If the current value is 1:
    - Write the value 1.
    - Move one slot to the right.
    - Continue with state A.
