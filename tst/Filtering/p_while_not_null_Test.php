<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_while_not_null;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_while_not_null_Test extends TestCase
{
    public function test_p_while_not_null(): void
    {
        pipe([])
        ->to(p_while_not_null())
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([])
        ->to(p_while_not_null(preserveKeys: true))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => null, 'd' => 4])
        ->to(p_while_not_null())
        ->to(shouldIterateLike([1, 2], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'c' => null, 'd' => 4])
        ->to(p_while_not_null(preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'b' => 2], repeatedly: true));
    }
}
