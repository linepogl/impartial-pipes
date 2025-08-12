<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_flat_map;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_flat_map_Test extends TestCase
{
    public function test_p_flat_map(): void
    {
        pipe([])
        ->to(p_flat_map(fn (int $x) => [$x, $x]))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_flat_map(fn (int $x) => [$x, $x]))
        ->to(shouldRepeatedlyIterateLike([1, 1, 2, 2, 3, 3, 4, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_flat_map(fn (int $x, string $k) => [$x, $k]))
        ->to(shouldRepeatedlyIterateLike([1, 'a', 2, 'b', 3, 'c', 4, 'd']));
    }
}
