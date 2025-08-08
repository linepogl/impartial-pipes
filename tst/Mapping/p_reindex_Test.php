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
        $this
            ->expect([])
            ->pipe(p_reindex(fn (int $x) => $x * $x))
            ->toIterateLike([]);

        $this
            ->expect([1, 2, 3, 4])
            ->pipe(p_reindex(fn (int $x) => $x * $x))
            ->toIterateLike([1 => 1, 4 => 2, 9 => 3, 16 => 4]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_reindex(fn (int $x) => $x * $x))
            ->toIterateLike([1 => 1, 4 => 2, 9 => 3, 16 => 4]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_reindex(fn (int $x, string $k) => $x . $k))
            ->toIterateLike(['1a' => 1, '2b' => 2, '3c' => 3, '4d' => 4]);

        $this
            ->expect(['a' => 1, 'b' => 1, 'c' => 2, 'd' => 2])
            ->pipe(p_reindex(fn (int $x) => $x * $x))
            ->toIterateLike([1 => 1, 4 => 2]);
    }
}
