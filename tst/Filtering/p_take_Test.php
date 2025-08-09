<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_take;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_take_Test extends TestCase
{
    public function test_p_take(): void
    {
        pipe([])
        ->to(p_take(2))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_take(2, preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2))
        ->to(p_assert_iterates_like([1, 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2, preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1, 'b' => 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2, preserveKeys: true))
        ->to(p_assert_iterates_like([]));
    }
}
