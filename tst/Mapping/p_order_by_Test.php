<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_order_by;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_order_by_Test extends TestCase
{
    public function test_p_order_by(): void
    {
        pipe([])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_order_by(fn (int $x) => abs($x), descending: true))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_order_by(fn (int $x, string $k) => $k))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_order_by(fn (int $x, string $k) => $k, descending: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_assert_iterates_like([1, -1, 2, -2, 3, -3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x), descending: true))
        ->to(p_assert_iterates_like([3, -3, 2, -2, 1, -1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0]))
        ->to(p_assert_iterates_like([1, -1, 2, -2, 3, -3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], descending: true))
        ->to(p_assert_iterates_like([3, -3, 2, -2, 1, -1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x), descending: true, preserveKeys: true))
        ->to(p_assert_iterates_like(['c' => 3, 'cc' => -3, 'b' => 2, 'bb' => -2, 'a' => 1, 'aa' => -1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], descending: true, preserveKeys: true))
        ->to(p_assert_iterates_like(['c' => 3, 'cc' => -3, 'b' => 2, 'bb' => -2, 'a' => 1, 'aa' => -1]));
    }
}
