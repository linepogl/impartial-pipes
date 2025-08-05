<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

use function pipes\it_flat_map;

/**
 * @internal
 */
final class it_flat_map_Test extends TestCase
{
    public function test_flat_map(): void
    {
        $this->assertEquals([], iterator_to_array(it_flat_map(fn (int $x, int $y) => [$x + $y])([])));
        $this->assertEquals([2, 1, 3, 3, 4, 5], iterator_to_array(it_flat_map(fn (int $x, int $k) => [$x + 1, $x + $k])([1, 2, 3])));
        $this->assertEquals(['a','aA','b','bB'], iterator_to_array(it_flat_map(fn (string $x, string $k) => [$x, $x.$k])(['A' => 'a', 'B' => 'b'])));
    }
}
