<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_to_array;
use function Tests\p_assert_equals;
use function Tests\pipe;

/**
 * @internal
 */
final class p_to_array_Test extends UnitTestCase
{
    public function test_p_to_array(): void
    {
        pipe([])
        ->to(p_to_array())
        ->to(p_assert_equals([]));

        pipe([1,2])
        ->to(p_to_array())
        ->to(p_assert_equals([1,2]));

        pipe(new SimpleIterator([1,2,3]))
        ->to(p_to_array())
        ->to(p_assert_equals([1,2,3]));

        pipe(new UniterableArrayIterator([1,2,3,4]))
        ->to(p_to_array())
        ->to(p_assert_equals([1,2,3,4]));
    }
}
