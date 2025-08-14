<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_while;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_while_Test extends TestCase
{
    public function test_p_while(): void
    {
        pipe([])
        ->to(p_while(fn (int $x) => $x % 2 === 1))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([])
        ->to(p_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x) => $x % 2 === 1))
        ->to(shouldIterateLike([1], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x, string $k) => $k === 'a'))
        ->to(shouldIterateLike([1], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1], repeatedly: true));
    }
}
