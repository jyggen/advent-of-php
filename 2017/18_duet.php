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

function verify_register(array &$registers, array $parts): void
{
    if (true === isset($parts[1]) && false === is_numeric($parts[1]) && false === isset($registers[$parts[1]])) {
        $registers[$parts[1]] = 0;
    }

    if (true === isset($parts[2]) && false === is_numeric($parts[2]) && false === isset($registers[$parts[2]])) {
        $registers[$parts[2]] = 0;
    }
}

$instructions = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$instructions = explode("\n", $instructions);
$length = count($instructions);
$lastPlayed = null;
$registers = [];

for ($i = 0; $i < $length; ++$i) {
    $parts = explode(' ', $instructions[$i]);

    verify_register($registers, $parts);

    if (true === isset($parts[2])) {
        $parts[2] = false === is_numeric($parts[2])
            ? $registers[$parts[2]]
            : (int) $parts[2];
    }

    switch ($parts[0]) {
        case 'add':
            $registers[$parts[1]] += $parts[2];
            break;
        case 'jgz':
            $parts[1] = false === is_numeric($parts[1])
                ? $registers[$parts[1]]
                : (int) $parts[1];

            if ($parts[1] > 0) {
                $i += $parts[2] - 1;
            }
            break;
        case 'mod':
            $registers[$parts[1]] %= $parts[2];
            break;
        case 'mul':
            $registers[$parts[1]] *= $parts[2];
            break;
        case 'rcv':
            break 2;
        case 'set':
            $registers[$parts[1]] = $parts[2];
            break;
        case 'snd':
            $parts[1] = false === is_numeric($parts[1])
                ? $registers[$parts[1]]
                : (int) $parts[1];

            $lastPlayed = $parts[1];
            break;
    }
}

echo $lastPlayed.PHP_EOL;

$programs = [0, 1];
$counts = [];
$indices = [];
$queue = [];
$registers = [];
$waiting = [];

foreach ($programs as $program) {
    $counts[$program] = 0;
    $indices[$program] = 0;
    $waiting[$program] = false;
    $queue[$program] = [];
    $registers[$program] = [
        'p' => $program,
    ];
}

do {
    $state = $registers;

    foreach ($programs as $program) {
        $other = 1 === $program ? 0 : 1;
        $parts = explode(' ', $instructions[$indices[$program]]);

        verify_register($registers[$program], $parts);

        if (true === isset($parts[2])) {
            $parts[2] = false === is_numeric($parts[2])
                ? $registers[$program][$parts[2]]
                : (int) $parts[2];
        }

        switch ($parts[0]) {
            case 'add':
                $registers[$program][$parts[1]] += $parts[2];
                break;
            case 'jgz':
                $parts[1] = false === is_numeric($parts[1])
                    ? $registers[$program][$parts[1]]
                    : (int) $parts[1];

                if ($parts[1] > 0) {
                    $indices[$program] += $parts[2] - 1;
                }
                break;
            case 'mod':
                $registers[$program][$parts[1]] %= $parts[2];
                break;
            case 'mul':
                $registers[$program][$parts[1]] *= $parts[2];
                break;
            case 'rcv':
                $value = array_shift($queue[$program]);

                if (null === $value) {
                    $waiting[$program] = true;
                    --$indices[$program];
                    break;
                }

                $waiting[$program] = false;
                $registers[$program][$parts[1]] = $value;
                break;
            case 'set':
                $registers[$program][$parts[1]] = $parts[2];
                break;
            case 'snd':
                $parts[1] = false === is_numeric($parts[1])
                    ? $registers[$program][$parts[1]]
                    : (int) $parts[1];

                ++$counts[$program];
                $queue[$other][] = $parts[1];
                break;
        }

        ++$indices[$program];
    }
} while (false === min($waiting));

echo $counts[1].PHP_EOL;

__halt_compiler();
set i 31
set a 1
mul p 17
jgz p p
mul a 2
add i -1
jgz i -2
add a -1
set i 127
set p 464
mul p 8505
mod p a
mul p 129749
add p 12345
mod p a
set b p
mod b 10000
snd b
add i -1
jgz i -9
jgz a 3
rcv b
jgz b -1
set f 0
set i 126
rcv a
rcv b
set p a
mul p -1
add p b
jgz p 4
snd a
set a b
jgz 1 3
snd b
set f 1
add i -1
jgz i -11
snd a
jgz f -16
jgz a -19
