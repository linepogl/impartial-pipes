<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_order_by;
use function ImpartialPipes\p_then_by;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_then_by_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_then_by(): void
    {
        pipe([])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_then_by(fn (int $x, string $k) => $k))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_order_by(fn (int $x) => abs($x), descending: true))
        ->to(p_then_by(fn (int $x, string $k) => $k, descending: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_order_by(fn (int $x, string $k) => $k[0]))
        ->to(p_then_by(fn (int $x) => $x))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], descending: true))
        ->to(p_then_by(fn (int $x) => $x, descending: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_then_by(fn (int $x, string $k) => $k))
        ->to(self::iteratesLike([1, -1, 2, -2, 3, -3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x)))
        ->to(p_then_by(fn (int $x, string $k) => $k, descending: true))
        ->to(self::iteratesLike([-1, 1, -2, 2, -3, 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
        ->to(p_then_by(fn (int $x, string $k) => $k))
        ->to(self::iteratesLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x) => abs($x), preserveKeys: true))
        ->to(p_then_by(fn (int $x, string $k) => $k, descending: true))
        ->to(self::iteratesLike(['aa' => -1, 'a' => 1, 'bb' => -2, 'b' => 2, 'cc' => -3, 'c' => 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0]))
        ->to(p_then_by(fn (int $x) => $x))
        ->to(self::iteratesLike([-1, 1, -2, 2, -3, 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0]))
        ->to(p_then_by(fn (int $x) => $x, descending: true))
        ->to(self::iteratesLike([1, -1, 2, -2, 3, -3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(p_then_by(fn (int $x) => $x))
        ->to(self::iteratesLike(['aa' => -1, 'a' => 1, 'bb' => -2, 'b' => 2, 'cc' => -3, 'c' => 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'aa' => -1, 'bb' => -2, 'cc' => -3])
        ->to(p_order_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(p_then_by(fn (int $x) => $x, descending: true))
        ->to(self::iteratesLike(['a' => 1, 'aa' => -1, 'b' => 2, 'bb' => -2, 'c' => 3, 'cc' => -3], rewind: true));
    }
}
