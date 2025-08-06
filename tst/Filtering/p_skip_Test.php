<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_skip;

/**
 * @internal
 */
final class p_skip_Test extends UnitTestCase
{
    public function test_p_skip(): void
    {
        $this
            ->expect([])
            ->pipe(p_skip(2))
            ->toIterateLike([]);

        $this
            ->expect([])
            ->pipe(p_skip(2, preserveKeys: true))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_skip(2))
            ->toIterateLike([3, 4]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_skip(2, preserveKeys: true))
            ->toIterateLike(['c' => 3, 'd' => 4]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_skip(-2))
            ->toIterateLike([1, 2, 3, 4]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_skip(-2, preserveKeys: true))
            ->toIterateLike(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);

    }
}
