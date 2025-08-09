<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_filter;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_filter_Test extends TestCase
{
    public function test_p_filter(): void
    {
        pipe([])
        ->to(p_filter(fn (int $x) => $x % 2 === 0))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_filter(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x) => $x % 2 === 0))
        ->to(p_assert_iterates_like([2, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(p_assert_iterates_like(['b' => 2, 'd' => 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x, string $k) => $k === 'b'))
        ->to(p_assert_iterates_like([2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter(fn (int $x, string $k) => $k === 'b', preserveKeys: true))
        ->to(p_assert_iterates_like(['b' => 2]));
    }
}
