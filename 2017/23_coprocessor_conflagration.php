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

function get_value(array $registers, string $value): int
{
    if (false === is_numeric($value)) {
        return $registers[$value];
    }

    return (int) $value;
}

function is_prime(int $value): bool
{
    if (1 === $value || 2 === $value || 0 === $value % 2) {
        return false;
    }

    $upperBound = ceil(sqrt($value));

    for ($i = 3; $i <= $upperBound; $i += 2) {
        if (0 === $value % $i) {
            return false;
        }
    }

    return true;
}

function run(array $instructions, bool $debug): int
{
    $length = count($instructions);
    $multipliers = 0;
    $registers = array_fill_keys(range('a', 'h'), 0);

    if (false === $debug) {
        $registers['a'] = 1;
    }

    for ($i = 0; $i < $length; ++$i) {
        $parts = $instructions[$i];

        if (false === $debug && 8 === $i) {
            $registers['f'] = is_prime($registers['b']) ? 1 : 0;
            $i += 15;

            continue;
        }

        switch ($parts[0]) {
            case 'jnz':
                if (0 !== get_value($registers, $parts[1])) {
                    $i += get_value($registers, $parts[2]) - 1;
                }
                break;
            case 'mul':
                $registers[$parts[1]] *= get_value($registers, $parts[2]);
                ++$multipliers;
                break;
            case 'set':
                $registers[$parts[1]] = get_value($registers, $parts[2]);
                break;
            case 'sub':
                $registers[$parts[1]] -= get_value($registers, $parts[2]);
                break;
        }
    }

    return true === $debug ? $multipliers : $registers['h'];
}

$instructions = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$instructions = array_map(static function (string $instruction): array {
    return explode(' ', $instruction);
}, explode("\n", $instructions));

echo run($instructions, true).PHP_EOL;
echo run($instructions, false).PHP_EOL;

__halt_compiler();
set b 57
set c b
jnz a 2
jnz 1 5
mul b 100
sub b -100000
set c b
sub c -17000
set f 1
set d 2
set e 2
set g d
mul g e
sub g b
jnz g 2
set f 0
sub e -1
set g e
sub g b
jnz g -8
sub d -1
set g d
sub g b
jnz g -13
jnz f 2
sub h -1
set g b
sub g c
jnz g 2
jnz 1 3
sub b -17
jnz 1 -23
