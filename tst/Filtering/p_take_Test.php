<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_take;
use function ImpartialPipes\pipe;
use function Tests\shouldIterateLike;

/**
 * @internal
 */
final class p_take_Test extends TestCase
{
    public function test_p_take(): void
    {
        pipe([])
        ->to(p_take(2))
        ->to(shouldIterateLike([]));

        pipe([])
        ->to(p_take(2, preserveKeys: true))
        ->to(shouldIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2))
        ->to(shouldIterateLike([1, 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2, preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'b' => 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2))
        ->to(shouldIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2, preserveKeys: true))
        ->to(shouldIterateLike([]));
    }
}
