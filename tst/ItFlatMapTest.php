<?php

declare(strict_types=1);

namespace Tests;

use function Pipes\it_flat_map;

/**
 * @internal
 */
final class ItFlatMapTest extends UnitTestCase
{
    public function test_flat_map(): void
    {
        $this->assertIterEquals([], it_flat_map(fn (int $x, int $y) => [$x + $y])([]));
        $this->assertIterEquals([2, 1, 3, 3, 4, 5], it_flat_map(fn (int $x, int $k) => [$x + 1, $x + $k])([1, 2, 3]));
        $this->assertIterEquals(['a','aA','b','bB'], it_flat_map(fn (string $x, string $k) => [$x, $x.$k])(['A' => 'a', 'B' => 'b']));
    }
}
