<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_order_by;
use function ImpartialPipes\p_then_by;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_then_by_Test extends TestCase
{
    public function test_p_then_by(): void
    {
        pipe([])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_then_by(fn (int $x, string $k) => $k))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([])
        ->to(p_order_by(fn (int $x) => abs($x), descending: true))
        ->to(p_then_by(fn (int $x, string $k) => $k, descending: true))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([])
        ->to(p_order_by(fn (int $x, string $k) => $k[0]))
        ->to(p_then_by(fn (int $x) => $x))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], descending: true))
        ->to(p_then_by(fn (int $x) => $x, descending: true))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_then_by(fn (int $x, string $k) => $k))
        ->to(shouldRepeatedlyIterateLike([1, -1, 2, -2, 3, -3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_then_by(fn (int $x, string $k) => $k, descending: true))
        ->to(shouldRepeatedlyIterateLike([-1, 1, -2, 2, -3, 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
        ->to(p_then_by(fn (int $x, string $k) => $k))
        ->to(shouldRepeatedlyIterateLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
        ->to(p_then_by(fn (int $x, string $k) => $k, descending: true))
        ->to(shouldRepeatedlyIterateLike(['aa' => -1, 'a' => 1, 'bb' => -2, 'b' => 2, 'cc' => -3, 'c' => 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0]))
        ->to(p_then_by(fn (int $x) => $x))
        ->to(shouldRepeatedlyIterateLike([-1, 1, -2, 2, -3, 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0]))
        ->to(p_then_by(fn (int $x) => $x, descending: true))
        ->to(shouldRepeatedlyIterateLike([1, -1, 2, -2, 3, -3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(p_then_by(fn (int $x) => $x))
        ->to(shouldRepeatedlyIterateLike(['aa' => -1, 'a' => 1, 'bb' => -2, 'b' => 2, 'cc' => -3, 'c' => 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(p_then_by(fn (int $x) => $x, descending: true))
        ->to(shouldRepeatedlyIterateLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3]));
    }
}
