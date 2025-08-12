<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_take;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_take_Test extends TestCase
{
    public function test_p_take(): void
    {
        pipe([])
        ->to(p_take(2))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([])
        ->to(p_take(2, preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2))
        ->to(shouldRepeatedlyIterateLike([1, 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2, preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike(['a' => 1, 'b' => 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2, preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike([]));
    }
}
