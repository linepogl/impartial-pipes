<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;
use function Pipes\p_unique;
use const Pipes\identity;

/**
 * @internal
 */
final class p_unique_Test extends UnitTestCase
{
    public function test_p_filter(): void
    {
        $this->assertIterEquals(
            [],
            [] |> p_unique(identity, preserveKeys: true),
        );
        $this->assertIterEquals(
            [],
            [] |> p_unique(identity, preserveKeys: false),
        );
//        $this->assertIterEquals(
//            [2, 3],
//            [1, 2, 3] |> p_filter(fn (int $x) => $x > 1, preserveKeys: false),
//        );
//        $this->assertIterEquals(
//            [1 => 2, 2 => 3],
//            [1, 2, 3] |> p_filter(fn (int $x) => $x > 1, preserveKeys: true),
//        );
//        $this->assertIterEquals(
//            [3],
//            [1, 2, 3] |> p_filter(fn (int $x, int $k) => $k > 1, preserveKeys: false),
//        );
//        $this->assertIterEquals(
//            [2 => 3],
//            [1, 2, 3] |> p_filter(fn (int $x, int $k) => $k > 1, preserveKeys: true),
//        );
    }

//    public function test_p_unique_is_rewindable(): void
//    {
//        $a = [1, 2, 3] |> p_filter(fn (int $x) => $x > 1, preserveKeys: false);
//        $this->assertIterEquals([2, 3], $a);
//        $this->assertIterEquals([2, 3], $a); // again to see if $a is rewindable
//        $a = [1, 2, 3] |> p_filter(fn (int $x) => $x > 1, preserveKeys: true);
//        $this->assertIterEquals([1 => 2, 2 => 3], $a);
//        $this->assertIterEquals([1 => 2, 2 => 3], $a); // again to see if $a is rewindable
//    }
}
