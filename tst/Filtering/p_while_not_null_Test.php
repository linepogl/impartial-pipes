<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_while_not_null;
use function ImpartialPipes\pipe;
use function Should\shouldRepeatedlyIterateLike;

/**
 * @internal
 */
final class p_while_not_null_Test extends TestCase
{
    public function test_p_while_not_null(): void
    {
        pipe([])
        ->to(p_while_not_null())
        ->to(shouldRepeatedlyIterateLike([]));

        pipe([])
        ->to(p_while_not_null(preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike([]));

        pipe(['a' => 1, 'b' => 2, 'c' => null, 'd' => 4])
        ->to(p_while_not_null())
        ->to(shouldRepeatedlyIterateLike([1, 2]));

        pipe(['a' => 1, 'b' => 2, 'c' => null, 'd' => 4])
        ->to(p_while_not_null(preserveKeys: true))
        ->to(shouldRepeatedlyIterateLike(['a' => 1, 'b' => 2]));
    }
}
