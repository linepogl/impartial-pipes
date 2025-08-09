<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_keys;
use function Tests\p_assert_iterates_like;
use function Tests\pipe;

/**
 * @internal
 */
final class p_keys_Test extends UnitTestCase
{
    public function test_p_keys(): void
    {
        pipe([])
        ->to(p_keys())
        ->to(p_assert_iterates_like([]));

        pipe([1, 2, 3])
        ->to(p_keys())
        ->to((p_assert_iterates_like([0, 1, 2])));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_keys())
        ->to((p_assert_iterates_like(['a', 'b', 'c', 'd'])));
    }
}
