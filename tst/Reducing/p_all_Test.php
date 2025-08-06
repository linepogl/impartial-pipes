<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;
use function Pipes\p_all;

/**
 * @internal
 */
final class p_all_Test extends UnitTestCase
{
    public function test_p_all(): void
    {
        $this->assertTrue(
            [] |> p_all(static fn (int $x) => $x > 1),
        );
        $this->assertTrue(
            [] |> p_all(static fn (int $x, string $key) => $key === 'a'),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_all(static fn (int $x) => $x > 0),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_all(static fn (int $x) => $x < 3),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_all(static fn (int $x, string $key) => $key >= 'a'),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_all(static fn (int $x, string $key) => $key < 'c'),
        );
    }
}
