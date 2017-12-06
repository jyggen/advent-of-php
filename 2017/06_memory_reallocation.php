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

final class Reallocator
{
    /**
     * @var int
     */
    private $length;

    /**
     * @var array|int[]
     */
    private $state;

    /**
     * @param int[] $state
     */
    public function __construct(array $state)
    {
        $this->length = count($state);
        $this->state = $state;
    }

    public function reallocate(): string
    {
        $highestKey = array_reduce(array_keys($this->state), function (?int $carry, int $key): int {
            if (null === $carry || $this->state[$key] > $this->state[$carry]) {
                return $key;
            }

            return $carry;
        });

        $distribute = $this->state[$highestKey];
        $this->state[$highestKey] = 0;
        $i = $highestKey;

        while ($distribute > 0) {
            $i = ($i + 1) % $this->length;

            ++$this->state[$i];
            --$distribute;
        }

        return json_encode($this->state);
    }
}

$input = read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$input = preg_split('/\s/', $input);
$stateHash = json_encode($input);
$seenStates = [$stateHash];
$reallocator = new Reallocator($input);
$walks = 0;

do {
    $seenStates[] = $stateHash;
    $stateHash = $reallocator->reallocate();

    ++$walks;
} while (false === in_array($stateHash, $seenStates, true));

echo $walks.PHP_EOL;

$expectedHash = $stateHash;
$walks = 0;

do {
    ++$walks;
} while ($reallocator->reallocate() !== $expectedHash);

echo $walks.PHP_EOL;

__halt_compiler();
10	3	15	10	5	15	5	15	9	2	5	8	5	2	3	6
