<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_filter_out;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_filter_out_Test extends UnitTestCase
{
    public function test_p_filter_out(): void
    {
        pipe([])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0))
        ->to(p_assert_iterates_like([1, 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1, 'c' => 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x, string $k) => $k === 'b'))
        ->to(p_assert_iterates_like([1, 3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x, string $k) => $k === 'b', preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1, 'c' => 3, 'd' => 4]));
    }
}
