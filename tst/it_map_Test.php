<?php

declare(strict_types=1);

namespace Tests;

use function Pipes\it_map;

/**
 * @internal
 */
final class it_map_Test extends UnitTestCase
{
    public function test_it_map(): void
    {
        $this->assertIterEquals(
            [],
            [] |> it_map(fn (int $x) => $x + 1),
        );
        $this->assertIterEquals(
            [2, 3, 4],
            [1, 2, 3] |> it_map(fn (int $x) => $x + 1),
        );
        $this->assertIterEquals(
            [1, 3, 5],
            [1, 2, 3] |> it_map(fn (int $x, int $k) => $x + $k),
        );
        $this->assertIterEquals(
            ['a' => 2, 3, 4],
            ['a' => 1, 2, 3] |> it_map(fn (int $x) => $x + 1),
        );
        $this->assertIterEquals(
            ['a' => '1a', '20', '31'],
            ['a' => 1, 2, 3] |> it_map(fn (int $x, int|string $k) => $x . $k),
        );
    }

    public function test_it_map_is_rewindable(): void
    {
        $a = [1, 2, 3] |> it_map(fn (int $x, int $k) => 2 * $x);
        $this->assertIterEquals([2, 4, 6], $a);
        $this->assertIterEquals([2, 4, 6], $a); // again to see if $a is rewindable
    }
}
