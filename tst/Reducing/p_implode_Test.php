<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_implode;
use function Tests\p_assert_equals;
use function Tests\pipe;

/**
 * @internal
 */
final class p_implode_Test extends UnitTestCase
{
    public function test_p_implode_with_arrays(): void
    {
        pipe([])
        ->to(p_implode())
        ->to(p_assert_equals(''));

        pipe([])
        ->to(p_implode('-'))
        ->to(p_assert_equals(''));

        pipe([1, 2, 3])
        ->to(p_implode())
        ->to(p_assert_equals('123'));

        pipe([1, 2, 3])
        ->to(p_implode('-'))
        ->to(p_assert_equals('1-2-3'));

        pipe([1, 'a', 3.3, null])
        ->to(p_implode())
        ->to(p_assert_equals('1a3.3'));

        pipe([1, 'a', 3.3, null])
        ->to(p_implode('-'))
        ->to(p_assert_equals('1-a-3.3-'));
    }

    public function test_p_implode_with_array_iterators(): void
    {
        pipe(new UniterableArrayIterator([]))
        ->to(p_implode())
        ->to(p_assert_equals(''));

        pipe(new UniterableArrayIterator([]))
        ->to(p_implode('-'))
        ->to(p_assert_equals(''));

        pipe(new UniterableArrayIterator([1, 2, 3]))
        ->to(p_implode())
        ->to(p_assert_equals('123'));

        pipe(new UniterableArrayIterator([1, 2, 3]))
        ->to(p_implode('-'))
        ->to(p_assert_equals('1-2-3'));

        pipe(new UniterableArrayIterator([1, 'a', 3.3, null]))
        ->to(p_implode())
        ->to(p_assert_equals('1a3.3'));

        pipe(new UniterableArrayIterator([1, 'a', 3.3, null]))
        ->to(p_implode('-'))
        ->to(p_assert_equals('1-a-3.3-'));
    }

    public function test_p_implode_with_simple_iterators(): void
    {
        pipe(new SimpleIterator([]))
        ->to(p_implode())
        ->to(p_assert_equals(''));

        pipe(new SimpleIterator([]))
        ->to(p_implode('-'))
        ->to(p_assert_equals(''));

        pipe(new SimpleIterator([1, 2, 3]))
        ->to(p_implode())
        ->to(p_assert_equals('123'));

        pipe(new SimpleIterator([1, 2, 3]))
        ->to(p_implode('-'))
        ->to(p_assert_equals('1-2-3'));

        pipe(new SimpleIterator([1, 'a', 3.3, null]))
        ->to(p_implode())
        ->to(p_assert_equals('1a3.3'));

        pipe(new SimpleIterator([1, 'a', 3.3, null]))
        ->to(p_implode('-'))
        ->to(p_assert_equals('1-a-3.3-'));
    }
}
