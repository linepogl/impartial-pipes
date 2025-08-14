<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_map;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_map_Test extends TestCase
{
    public function test_p_map(): void
    {
        pipe([])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([1, 2, 3, 4])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to(shouldIterateLike([1, 4, 9, 16], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map(fn (int $x) => $x * $x))
        ->to(shouldIterateLike(['a' => 1, 'b' => 4, 'c' => 9, 'd' => 16], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map(fn (int $x, string $k) => $x . $k))
        ->to(shouldIterateLike(['a' => '1a', 'b' => '2b', 'c' => '3c', 'd' => '4d'], repeatedly: true));
    }
}
