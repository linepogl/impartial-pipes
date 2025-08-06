<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;
use function Pipes\p_filter;
use function Pipes\p_group_by;

/**
 * @internal
 */
final class p_group_by_Test extends UnitTestCase
{
    public function test_p_group_by(): void
    {
        $this->assertIterEquals(
            [],
            [] |> p_group_by(fn (int $x) => $x, preserveKeys: false),
        );

        $this->assertIterEquals(
            [1 => [1, 3], 0 => [2, 4]],
            ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
            |> p_group_by(fn (int $x) => $x % 2, preserveKeys: false),
        );

        $this->assertIterEquals(
            [1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]],
            ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
            |> p_group_by(fn (int $x) => $x % 2, preserveKeys: true),
        );

    }

    public function test_p_group_by_is_rewindable(): void
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4] |> p_group_by(fn (int $x) => $x % 2, preserveKeys: false);
        $this->assertIterEquals([1 => [1, 3], 0 => [2, 4]], $a);
        $this->assertIterEquals([1 => [1, 3], 0 => [2, 4]], $a); // again to see if $a is rewindable
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4] |> p_group_by(fn (int $x) => $x % 2, preserveKeys: true);
        $this->assertIterEquals([1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]], $a);
        $this->assertIterEquals([1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]], $a); // again to see if $a is rewindable
    }
}
