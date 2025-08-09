<?php

declare(strict_types=1);

namespace Tests\Mapping;

use Tests\UnitTestCase;

use function ImpartialPipes\p_values;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_values_Test extends UnitTestCase
{
    public function test_p_values(): void
    {
        pipe([])
        ->to(p_values())
        ->to(p_assert_iterates_like([]));

        pipe([1, 2, 3, 4])
        ->to(p_values())
        ->to(p_assert_iterates_like([1, 2, 3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_values())
        ->to(p_assert_iterates_like([1, 2, 3, 4]));
    }
}
