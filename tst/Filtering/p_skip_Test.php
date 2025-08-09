<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_skip;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_skip_Test extends UnitTestCase
{
    public function test_p_skip(): void
    {
        pipe([])
        ->to(p_skip(2))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_skip(2, preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(2))
        ->to(p_assert_iterates_like([3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(2, preserveKeys: true))
        ->to(p_assert_iterates_like(['c' => 3, 'd' => 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(-2))
        ->to(p_assert_iterates_like([1, 2, 3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(-2, preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]));

    }
}
