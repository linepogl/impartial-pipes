<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_flat_map;
use function Tests\p_assert_iterates_like;
use function Tests\pipe;

/**
 * @internal
 */
final class p_flat_map_Test extends UnitTestCase
{
    public function test_p_flat_map(): void
    {
        pipe([])
        ->to(p_flat_map(fn (int $x) => [$x, $x]))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_flat_map(fn (int $x) => [$x, $x]))
        ->to(p_assert_iterates_like([1, 1, 2, 2, 3, 3, 4, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_flat_map(fn (int $x, string $k) => [$x, $k]))
        ->to(p_assert_iterates_like([1, 'a', 2, 'b', 3, 'c', 4, 'd']));
    }
}
