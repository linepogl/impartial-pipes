<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_filter_out_nulls;

/**
 * @internal
 */
final class p_filter_out_nulls_Test extends UnitTestCase
{
    public function test_p_filter_out_nulls(): void
    {
        $this
            ->expect([])
            ->pipe(p_filter_out_nulls())
            ->toIterateLike([]);

        $this
            ->expect([])
            ->pipe(p_filter_out_nulls(preserveKeys: true))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
            ->pipe(p_filter_out_nulls())
            ->toIterateLike([1, 3]);

        $this
            ->expect(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
            ->pipe(p_filter_out_nulls(preserveKeys: true))
            ->toIterateLike(['a' => 1, 'c' => 3]);
    }
}
