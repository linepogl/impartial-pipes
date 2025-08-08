<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_order_by;

/**
 * @internal
 */
final class p_order_by_Test extends UnitTestCase
{
    public function test_p_order_by(): void
    {
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x) => abs($x)))
            ->toIterateLike([]);
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x) => abs($x), descending: true))
            ->toIterateLike([]);
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x, string $k) => $k))
            ->toIterateLike([]);
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x, string $k) => $k, descending: true))
            ->toIterateLike([]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x)))
            ->toIterateLike([1, -1, 2, -2, 3, -3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x), descending: true))
            ->toIterateLike([3, -3, 2, -2, 1, -1]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0]))
            ->toIterateLike([1, -1, 2, -2, 3, -3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0], descending: true))
            ->toIterateLike([3, -3, 2, -2, 1, -1]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
            ->toIterateLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x), descending: true, preserveKeys: true))
            ->toIterateLike(['c' => 3, 'cc' => -3, 'b' => 2, 'bb' => -2, 'a' => 1, 'aa' => -1]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
            ->toIterateLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0], descending: true, preserveKeys: true))
            ->toIterateLike(['c' => 3, 'cc' => -3, 'b' => 2, 'bb' => -2, 'a' => 1, 'aa' => -1]);
    }
}
