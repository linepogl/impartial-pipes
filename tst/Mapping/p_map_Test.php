<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_map;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_map_Test extends TestCase
{
    public function test_p_map(): void
    {
        pipe([])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([1, 2, 3, 4])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to(shouldRepeatedlyIterateLike([1, 4, 9, 16]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to(shouldRepeatedlyIterateLike(['a' => 1, 'b' => 4, 'c' => 9, 'd' => 16]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map(fn (int $x, string $k) => $x . $k))
        ->to(shouldRepeatedlyIterateLike(['a' => '1a', 'b' => '2b', 'c' => '3c', 'd' => '4d']));
    }
}
