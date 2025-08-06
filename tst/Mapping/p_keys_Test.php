<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_keys;

/**
 * @internal
 */
final class p_keys_Test extends UnitTestCase
{
    public function test_p_keys(): void
    {
        $this
            ->expect([])
            ->pipe(p_keys())
            ->toIterateLike([]);

        $this
            ->expect([1, 2, 3])
            ->pipe(p_keys())
            ->toIterateLike([0, 1, 2]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_keys())
            ->toIterateLike(['a', 'b', 'c', 'd']);
    }
}
