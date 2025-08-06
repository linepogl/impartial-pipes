<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_compact;

/**
 * @internal
 */
final class p_compact_Test extends UnitTestCase
{
    public function test_p_compact(): void
    {
        $this
            ->expect([])
            ->pipe(p_compact())
            ->toIterateLike([]);

        $this
            ->expect([])
            ->pipe(p_compact(preserveKeys: true))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
            ->pipe(p_compact())
            ->toIterateLike([1, 3]);

        $this
            ->expect(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
            ->pipe(p_compact(preserveKeys: true))
            ->toIterateLike(['a' => 1, 'c' => 3]);
    }
}
