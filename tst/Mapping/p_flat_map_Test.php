<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_flat_map;

/**
 * @internal
 */
final class p_flat_map_Test extends UnitTestCase
{
    public function test_p_flat_map(): void
    {
        $this
            ->expect([])
            ->pipe(p_flat_map(fn (int $x) => [$x, $x]))
            ->toIterateLike([]);

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_flat_map(fn (int $x) => [$x, $x]))
            ->toIterateLike([1, 1, 2, 2, 3, 3, 4, 4]);
        ;

        $this
            ->expect(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
            ->pipe(p_flat_map(fn (int $x, string $k) => [$x, $k]))
            ->toIterateLike([1, 'a', 2, 'b', 3, 'c', 4, 'd']);
        ;
    }
}
