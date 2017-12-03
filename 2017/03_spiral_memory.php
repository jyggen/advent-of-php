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

final class Spiral
{
    private const UP = 'u';

    private const RIGHT = 'r';

    private const DOWN = 'd';

    private const LEFT = 'l';

    /**
     * @var string
     */
    private $direction = self::RIGHT;

    /**
     * @var int[][]
     */
    private $spiral;

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    public function __construct()
    {
        $this->x = 0;
        $this->y = 0;
        $this->spiral = [
            0 => [
                0 => 1,
            ],
        ];
    }

    public function getValue(): int
    {
        return $this->spiral[$this->y][$this->x];
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function move(): void
    {
        switch ($this->direction) {
            case self::UP:
                --$this->y;

                if (false === isset($this->spiral[$this->y][$this->x - 1])) {
                    $this->direction = self::LEFT;
                }
                break;
            case self::RIGHT:
                ++$this->x;

                if (false === isset($this->spiral[$this->y - 1][$this->x])) {
                    $this->direction = self::UP;
                }
                break;
            case self::DOWN:
                ++$this->y;

                if (false === isset($this->spiral[$this->y][$this->x + 1])) {
                    $this->direction = self::RIGHT;
                }
                break;
            case self::LEFT:
                --$this->x;

                if (false === isset($this->spiral[$this->y + 1][$this->x])) {
                    $this->direction = self::DOWN;
                }
                break;
        }

        $value = 0;
        $value += $this->spiral[$this->y][$this->x - 1] ?? 0;
        $value += $this->spiral[$this->y - 1][$this->x - 1] ?? 0;
        $value += $this->spiral[$this->y - 1][$this->x] ?? 0;
        $value += $this->spiral[$this->y - 1][$this->x + 1] ?? 0;
        $value += $this->spiral[$this->y][$this->x + 1] ?? 0;
        $value += $this->spiral[$this->y + 1][$this->x + 1] ?? 0;
        $value += $this->spiral[$this->y + 1][$this->x] ?? 0;
        $value += $this->spiral[$this->y + 1][$this->x - 1] ?? 0;

        $this->spiral[$this->y][$this->x] = min(PHP_INT_MAX, $value);
    }
}

$input = (int) read_input($argv, __FILE__, __COMPILER_HALT_OFFSET__);
$spiral = new Spiral();

for ($i = 2; $i <= $input; ++$i) {
    $spiral->move();
}

echo abs($spiral->getY()) + abs($spiral->getX());
echo PHP_EOL;

$spiral = new Spiral();

while ($spiral->getValue() < $input) {
    $spiral->move();
}

echo $spiral->getValue();
echo PHP_EOL;

__halt_compiler();
368078
