<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_take_while;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_take_while_Test extends TestCase
{
    public function test_p_take_while(): void
    {
        pipe([])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1))
        ->to(shouldRepeatedlyIterateLike([1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike(['a' => 1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x, string $k) => $k === 'a'))
        ->to(shouldRepeatedlyIterateLike([1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike(['a' => 1]));
    }
}
