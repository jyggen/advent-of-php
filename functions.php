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

function read_input(array $argv, string $file, int $offset): string
{
    if (true === isset($argv[1])) {
        return trim($argv[1]);
    }

    $fp = fopen($file, 'rb');

    fseek($fp, $offset);

    return trim(stream_get_contents($fp));
}
