<?php

declare(strict_types=1);

namespace Tests\Combining;

use Tests\UnitTestCase;

use function ImpartialPipes\p_merge;
use function Tests\p_assert_iterates_like;
use function Tests\pipe;

/**
 * @internal
 */
final class p_merge_Test extends UnitTestCase
{
    public function test_p_merge(): void
    {
        pipe([])
        ->to(p_merge([]))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_merge([], preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe([1,2])
        ->to(p_merge([3,4]))
        ->to(p_assert_iterates_like([1,2,3,4]));

        pipe([1,2])
        ->to(p_merge([3,4], preserveKeys: true))
        ->to(p_assert_iterates_like([1,2]));

        pipe(['a' => 1,'b' => 2,'c' => 3])
        ->to(p_merge(['b' => 22,'c' => 33,'d' => 4]))
        ->to(p_assert_iterates_like([1,2,3,22,33,4]));

        pipe(['a' => 1,'b' => 2,'c' => '3'])
        ->to(p_merge(['b' => 2,'c' => 3,'d' => 4], preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1,'b' => 2,'c' => 3,'d' => 4]));
    }
}
