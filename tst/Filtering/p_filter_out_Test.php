<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_filter_out;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_filter_out_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_filter_out(): void
    {
        pipe([])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0))
        ->to(self::iteratesLike([1, 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'c' => 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x, string $k) => $k === 'b'))
        ->to(self::iteratesLike([1, 3, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x, string $k) => $k === 'b', preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'c' => 3, 'd' => 4], rewind: true));
    }
}
