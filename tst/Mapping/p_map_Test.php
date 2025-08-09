<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_map;
use function Tests\p_assert_iterates_like;
use function Tests\pipe;

/**
 * @internal
 */
final class p_map_Test extends UnitTestCase
{
    public function test_p_map(): void
    {
        pipe([])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to(p_assert_iterates_like([]));

        pipe([1, 2, 3, 4])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to((p_assert_iterates_like([1, 4, 9, 16])));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to((p_assert_iterates_like(['a' => 1, 'b' => 4, 'c' => 9, 'd' => 16])));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map(fn (int $x, string $k) => $x . $k))
        ->to((p_assert_iterates_like(['a' => '1a', 'b' => '2b', 'c' => '3c', 'd' => '4d'])));
    }
}
