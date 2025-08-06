<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;
use function ImpartialPipes\p_reindex;

/**
 * @internal
 */
final class p_reindex_Test extends UnitTestCase
{
    public function test_p_reindex(): void
    {
        $this->assertIterEquals(
            ['a' => 'a', 'b' => 'b'],
            ['a','b'] |> p_reindex(fn (string $x, int $k) => $x),
        );
    }

    public function test_p_reindex_is_rewindable(): void
    {
        $a = [1, 2, 3] |> p_reindex(fn (int $x, int $k) => 2 * $k);
        $this->assertIterEquals([0 => 1,2 => 2,4 => 3], $a);
        $this->assertIterEquals([0 => 1,2 => 2,4 => 3], $a); // again to see if $a is rewindable
    }
}
