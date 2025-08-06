<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;
use function Pipes\it_any;

/**
 * @internal
 */
final class it_any_Test extends UnitTestCase
{
    public function test_it_any(): void
    {
        $this->assertFalse(
            [] |> it_any(static fn (int $x) => $x > 1),
        );
        $this->assertFalse(
            [] |> it_any(static fn (int $x, string $key) => $key === 'a'),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_any(static fn (int $x) => $x > 1),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_any(static fn (int $x) => $x < 0),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_any(static fn (int $x, string $key) => $key === 'a'),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_any(static fn (int $x, string $key) => $key === 'd'),
        );
    }
}
