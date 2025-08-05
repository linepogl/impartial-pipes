<?php

declare(strict_types=1);

namespace Tests;

use function Pipes\it_map;

/**
 * @internal
 */
final class ItMapTest extends UnitTestCase
{
    public function test_map(): void
    {
        $this->assertIterEquals([], it_map(fn (int $x) => $x + 1)([]));
        $this->assertIterEquals([2, 3, 4], it_map(fn (int $x) => $x + 1)([1, 2, 3]));
        $this->assertIterEquals([1, 3, 5], it_map(fn (int $x, int $k) => $x + $k)([1, 2, 3]));
        $this->assertIterEquals(['a' => 2, 3, 4], it_map(fn (int $x) => $x + 1)(['a' => 1, 2, 3]));
        $this->assertIterEquals(['a' => '1a', '20', '31'], it_map(fn (int $x, int|string $k) => $x . $k)((['a' => 1, 2, 3])));
    }
}
