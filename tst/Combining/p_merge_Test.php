<?php

declare(strict_types=1);

namespace Tests\Combining;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_merge;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_merge_Test extends TestCase
{
    public function test_p_merge(): void
    {
        pipe([])
        ->to(p_merge([]))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([])
        ->to(p_merge([], preserveKeys: true))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([1,2])
        ->to(p_merge([3,4]))
        ->to(shouldIterateLike([1,2,3,4], repeatedly: true));

        pipe([1,2])
        ->to(p_merge([3,4], preserveKeys: true))
        ->to(shouldIterateLike([1,2], repeatedly: true));

        pipe(['a' => 1,'b' => 2,'c' => 3])
        ->to(p_merge(['b' => 22,'c' => 33,'d' => 4]))
        ->to(shouldIterateLike([1,2,3,22,33,4], repeatedly: true));

        pipe(['a' => 1,'b' => 2,'c' => '3'])
        ->to(p_merge(['b' => 2,'c' => 3,'d' => 4], preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1,'b' => 2,'c' => '3','d' => 4], repeatedly: true));
    }
}
