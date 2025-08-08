<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_filter_out;

/**
 * @internal
 */
final class p_filter_out_Test extends UnitTestCase
{
    public function test_p_filter_out(): void
    {
        $this
            ->expect([])
            ->pipe(p_filter_out(fn (int $x) => $x % 2 === 0))
            ->toIterateLike([]);

        $this
            ->expect([])
            ->pipe(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_filter_out(fn (int $x) => $x % 2 === 0))
            ->toIterateLike([1, 3]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
            ->toIterateLike(['a' => 1, 'c' => 3]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_filter_out(fn (int $x, string $k) => $k === 'b'))
            ->toIterateLike([1, 3, 4]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_filter_out(fn (int $x, string $k) => $k === 'b', preserveKeys: true))
            ->toIterateLike(['a' => 1, 'c' => 3, 'd' => 4]);
    }
}
