<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;
use function ImpartialPipes\p_compact;

/**
 * @internal
 */
final class p_compact_Test extends UnitTestCase
{
    public function test_p_compact(): void
    {
        $this->assertIterEquals(
            [],
            [] |> p_compact(preserveKeys: false),
        );
        $this->assertIterEquals(
            [],
            [] |> p_compact(preserveKeys: true),
        );
        $this->assertIterEquals(
            [1, 3],
            [1, null, 3] |> p_compact(preserveKeys: false),
        );
        $this->assertIterEquals(
            [1, 2 => 3],
            [1, null, 3] |> p_compact(preserveKeys: true),
        );
    }

    public function test_p_compact_is_rewindable(): void
    {
        $a = [1, null, 3] |> p_compact(preserveKeys: true);
        $this->assertIterEquals([1, 2 => 3], $a);
        $this->assertIterEquals([1, 2 => 3], $a); // again to see if $a is rewindable

        $a = [1, null, 3] |> p_compact(preserveKeys: false);
        $this->assertIterEquals([1, 3], $a);
        $this->assertIterEquals([1, 3], $a); // again to see if $a is rewindable
    }
}
