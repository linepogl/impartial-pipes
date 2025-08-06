<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;
use function Pipes\p_flat_map;

/**
 * @internal
 */
final class p_flat_map_Test extends UnitTestCase
{
    public function test_p_flat_map(): void
    {
        $this->assertIterEquals(
            [],
            [] |> p_flat_map(fn (int $x, int $k) => [$k, $x]),
        );

        $this->assertIterEquals(
            ['a', 1, 'b', 2, 'c', 3],
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_flat_map(fn (int $x, string $k) => [$k, $x]),
        );

        $this->assertIterEquals(
            ['a','aA','b','bB'],
            ['A' => 'a', 'B' => 'b'] |> p_flat_map(fn (string $x, string $k) => [$x, $x . $k]),
        );
    }

    public function test_p_flat_map_is_rewindable(): void
    {
        $a = [1, 2, 3] |> p_flat_map(fn (int $x) => [$x, 2 * $x]);
        $this->assertIterEquals([1, 2, 2, 4, 3, 6], $a);
        $this->assertIterEquals([1, 2, 2, 4, 3, 6], $a); // again to see if $a is rewindable
    }
}
