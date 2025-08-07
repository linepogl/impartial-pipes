<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_foreach;
use function ImpartialPipes\p_order_by;
use function ImpartialPipes\p_then_by;
use function ImpartialPipes\p_values;

/**
 * @internal
 */
final class p_order_by_then_by_Test extends UnitTestCase
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
            ->toIterateLike(['c' => 3, 'cc' => -3, 'b' => 2, 'bb' => -2, 'a' => 1, 'aa' => -1]);;
    }
    public function test_p_then_by(): void
    {
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x) => abs($x)))
            ->pipe(p_then_by(fn (int $x, string $k) => $k))
            ->toIterateLike([]);
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x) => abs($x), descending: true))
            ->pipe(p_then_by(fn (int $x, string $k) => $k, descending: true))
            ->toIterateLike([]);
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0]))
            ->pipe(p_then_by(fn (int $x) => $x))
            ->toIterateLike([]);
        $this
            ->expect([])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0], descending: true))
            ->pipe(p_then_by(fn (int $x) => $x, descending: true))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x)))
            ->pipe(p_then_by(fn (int $x, string $k) => $k))
            ->toIterateLike([1, -1, 2, -2, 3, -3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x)))
            ->pipe(p_then_by(fn (int $x, string $k) => $k, descending: true))
            ->toIterateLike([-1, 1, -2, 2, -3, 3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
            ->pipe(p_then_by(fn (int $x, string $k) => $k))
            ->toIterateLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
            ->pipe(p_then_by(fn (int $x, string $k) => $k, descending: true))
            ->toIterateLike(['aa' => -1, 'a' => 1, 'bb' => -2, 'b' => 2, 'cc' => -3, 'c' => 3]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0]))
            ->pipe(p_then_by(fn (int $x) => $x))
            ->toIterateLike([-1, 1, -2, 2, -3, 3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0]))
            ->pipe(p_then_by(fn (int $x) => $x, descending: true))
            ->toIterateLike([1, -1, 2, -2, 3, -3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
            ->pipe(p_then_by(fn (int $x) => $x))
            ->toIterateLike(['aa' => -1, 'a' => 1, 'bb' => -2, 'b' => 2, 'cc' => -3, 'c' => 3]);
        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
            ->pipe(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
            ->pipe(p_then_by(fn (int $x) => $x, descending: true))
            ->toIterateLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]);
    }
}
