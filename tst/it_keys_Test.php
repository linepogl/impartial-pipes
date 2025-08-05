<?php

declare(strict_types=1);

namespace Tests;

use function Pipes\it_keys;

/**
 * @internal
 */
final class it_keys_Test extends UnitTestCase
{
    public function test_it_keys(): void
    {
        $this->assertIterEquals(
            [],
            [] |> it_keys(),
        );
        $this->assertIterEquals(
            [0, 1, 2],
            [1, 2, 3] |> it_keys(),
        );
        $this->assertIterEquals(
            ['a', 'b', 'c'],
            ['a' => 1, 'b' => 2, 'c' => 3] |> it_keys(),
        );
    }

    public function test_it_keys_is_rewindable(): void
    {
        $a = [1, 2, 3] |> it_keys();
        $this->assertIterEquals([0, 1, 2], $a);
        $this->assertIterEquals([0, 1, 2], $a); // again to see if $a is rewindable
    }
}
