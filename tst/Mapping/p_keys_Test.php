<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;
use function ImpartialPipes\p_keys;

/**
 * @internal
 */
final class p_keys_Test extends UnitTestCase
{
    public function test_p_keys(): void
    {
        $this->assertIterEquals(
            [],
            [] |> p_keys(),
        );
        $this->assertIterEquals(
            [0, 1, 2],
            [1, 2, 3] |> p_keys(),
        );
        $this->assertIterEquals(
            ['a', 'b', 'c'],
            ['a' => 1, 'b' => 2, 'c' => 3] |> p_keys(),
        );
    }

    public function test_p_keys_is_rewindable(): void
    {
        $a = [1, 2, 3] |> p_keys();
        $this->assertIterEquals([0, 1, 2], $a);
        $this->assertIterEquals([0, 1, 2], $a); // again to see if $a is rewindable
    }
}
