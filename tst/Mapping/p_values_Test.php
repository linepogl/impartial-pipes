<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_values;
use function ImpartialPipes\pipe;
use function Tests\shouldIterateLike;

/**
 * @internal
 */
final class p_values_Test extends TestCase
{
    public function test_p_values(): void
    {
        pipe([])
        ->to(p_values())
        ->to(shouldIterateLike([]));

        pipe([1, 2, 3, 4])
        ->to(p_values())
        ->to(shouldIterateLike([1, 2, 3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_values())
        ->to(shouldIterateLike([1, 2, 3, 4]));
    }
}
