<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_keys;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_keys_Test extends TestCase
{
    public function test_p_keys(): void
    {
        pipe([])
        ->to(p_keys())
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([1, 2, 3])
        ->to(p_keys())
        ->to(shouldIterateLike([0, 1, 2], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_keys())
        ->to(shouldIterateLike(['a', 'b', 'c', 'd'], repeatedly: true));
    }
}
