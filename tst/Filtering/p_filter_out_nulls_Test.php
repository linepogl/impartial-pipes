<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_filter_out_nulls;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_filter_out_nulls_Test extends UnitTestCase
{
    public function test_p_filter_out_nulls(): void
    {
        pipe([])
        ->to(p_filter_out_nulls())
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_filter_out_nulls(preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
        ->to(p_filter_out_nulls())
        ->to(p_assert_iterates_like([1, 3]));

        pipe(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
        ->to(p_filter_out_nulls(preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1, 'c' => 3]));
    }
}
