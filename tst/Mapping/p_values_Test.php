<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_values;

/**
 * @internal
 */
final class p_values_Test extends UnitTestCase
{
    public function test_p_values(): void
    {
        $this
            ->expect([])
            ->pipe(p_values())
            ->toIterateLike([]);

        $this
            ->expect([1, 2, 3, 4])
            ->pipe(p_values())
            ->toIterateLike([1, 2, 3, 4]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_values())
            ->toIterateLike([1, 2, 3, 4]);
    }
}
