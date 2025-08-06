<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_take;

/**
 * @internal
 */
final class p_take_Test extends UnitTestCase
{
    public function test_p_take(): void
    {
        $this
            ->expect([])
            ->pipe(p_take(2))
            ->toIterateLike([]);

        $this
            ->expect([])
            ->pipe(p_take(2, preserveKeys: true))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take(2))
            ->toIterateLike([1, 2]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take(2, preserveKeys: true))
            ->toIterateLike(['a' => 1, 'b' => 2]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take(-2))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_take(-2, preserveKeys: true))
            ->toIterateLike([]);

    }
}
