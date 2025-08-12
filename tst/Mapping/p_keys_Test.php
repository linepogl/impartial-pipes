<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_keys;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_keys_Test extends TestCase
{
    public function test_p_keys(): void
    {
        pipe([])
        ->to(p_keys())
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([1, 2, 3])
        ->to(p_keys())
        ->to(shouldRepeatedlyIterateLike([0, 1, 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_keys())
        ->to(shouldRepeatedlyIterateLike(['a', 'b', 'c', 'd']));
    }
}
