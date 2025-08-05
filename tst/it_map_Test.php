<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;

use function pipes\it_map;

/**
 * @internal
 */
final class it_map_Test extends TestCase
{
    public function test_map(): void
    {
        $this->assertEquals([], iterator_to_array(it_map(fn (int $x) => $x + 1)([])));
        $this->assertEquals([2, 3, 4], iterator_to_array(it_map(fn (int $x) => $x + 1)([1, 2, 3])));
        $this->assertEquals([1, 3, 5], iterator_to_array(it_map(fn (int $x, int $k) => $x + $k)([1, 2, 3])));
        $this->assertEquals(['a' => 2, 3, 4], iterator_to_array(it_map(fn (int $x) => $x + 1)(['a' => 1, 2, 3])));
        $this->assertEquals(['a' => '1a', '20', '31'], iterator_to_array(it_map(fn (int $x, int|string $k) => $x . $k)((['a' => 1, 2, 3]))));
    }
}
