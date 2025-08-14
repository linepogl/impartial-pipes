<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_skip_while;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_skip_while_Test extends TestCase
{
    public function test_p_skip_while(): void
    {
        pipe([])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1))
        ->to(shouldIterateLike([2, 3, 4], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(shouldIterateLike(['b' => 2, 'c' => 3, 'd' => 4], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x, string $k) => $k === 'a'))
        ->to(shouldIterateLike([2, 3, 4], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
        ->to(shouldIterateLike(['b' => 2, 'c' => 3, 'd' => 4], repeatedly: true));
    }
}
