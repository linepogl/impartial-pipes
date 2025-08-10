<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_unique;
use function ImpartialPipes\pipe;
use function Tests\shouldIterateLike;

/**
 * @internal
 */
final class p_unique_Test extends TestCase
{
    public function test_p_unique(): void
    {
        pipe([])
        ->to(p_unique())
        ->to(shouldIterateLike([]));

        pipe([])
        ->to(p_unique(preserveKeys: true))
        ->to(shouldIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 1, 'd' => 4])
        ->to(p_unique())
        ->to(shouldIterateLike([1, 2, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 1, 'd' => 4])
        ->to(p_unique(preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'b' => 2, 'd' => 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_unique(static fn (int $x) => $x % 2))
        ->to(shouldIterateLike([1, 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_unique(static fn (int $x) => $x % 2, preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'b' => 2]));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_unique(static fn (int $x, string $k) => $k[0]))
        ->to(shouldIterateLike([1, 3]));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_unique(static fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'b' => 3]));
    }
}
