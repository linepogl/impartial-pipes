<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_filter;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_filter_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_filter(): void
    {
        pipe([])
        ->to(p_filter(fn (int $x) => $x % 2 === 0))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_filter(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x) => $x % 2 === 0))
        ->to(self::iteratesLike([2, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(self::iteratesLike(['b' => 2, 'd' => 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x, string $k) => $k === 'b'))
        ->to(self::iteratesLike([2], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x, string $k) => $k === 'b', preserveKeys: true))
        ->to(self::iteratesLike(['b' => 2], rewind: true));
    }
}
