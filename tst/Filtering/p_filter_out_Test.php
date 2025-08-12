<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_filter_out;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_filter_out_Test extends TestCase
{
    public function test_p_filter_out(): void
    {
        pipe([])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0))
        ->to(shouldRepeatedlyIterateLike([1, 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x) => $x % 2 === 0, preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike(['a' => 1, 'c' => 3]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x, string $k) => $k === 'b'))
        ->to(shouldRepeatedlyIterateLike([1, 3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_filter_out(fn (int $x, string $k) => $k === 'b', preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike(['a' => 1, 'c' => 3, 'd' => 4]));
    }
}
