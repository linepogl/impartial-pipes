<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_skip;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_skip_Test extends TestCase
{
    public function test_p_skip(): void
    {
        pipe([])
        ->to(p_skip(2))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([])
        ->to(p_skip(2, preserveKeys: true))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(2))
        ->to(shouldIterateLike([3, 4], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(2, preserveKeys: true))
        ->to(shouldIterateLike(['c' => 3, 'd' => 4], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(-2))
        ->to(shouldIterateLike([1, 2, 3, 4], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(-2, preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], repeatedly: true));
    }
}
