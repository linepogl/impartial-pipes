<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;
use function Pipes\p_any;

/**
 * @internal
 */
final class p_any_Test extends UnitTestCase
{
    public function test_p_any(): void
    {
        $this->assertFalse(
            [] |> p_any(static fn (int $x) => $x > 1),
        );
        $this->assertFalse(
            [] |> p_any(static fn (int $x, string $key) => $key === 'a'),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_any(static fn (int $x) => $x > 1),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_any(static fn (int $x) => $x < 0),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_any(static fn (int $x, string $key) => $key === 'a'),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_any(static fn (int $x, string $key) => $key === 'd'),
        );
    }
}
