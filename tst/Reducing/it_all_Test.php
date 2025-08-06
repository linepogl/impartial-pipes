<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\UnitTestCase;
use function Pipes\it_all;

/**
 * @internal
 */
final class it_all_Test extends UnitTestCase
{
    public function test_it_all(): void
    {
        $this->assertTrue(
            [] |> it_all(static fn (int $x) => $x > 1),
        );
        $this->assertTrue(
            [] |> it_all(static fn (int $x, string $key) => $key === 'a'),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_all(static fn (int $x) => $x > 0),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_all(static fn (int $x) => $x < 3),
        );
        $this->assertTrue(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_all(static fn (int $x, string $key) => $key >= 'a'),
        );
        $this->assertFalse(
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_all(static fn (int $x, string $key) => $key < 'c'),
        );
    }
}
