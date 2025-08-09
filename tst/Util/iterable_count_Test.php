<?php

declare(strict_types=1);

namespace Tests\Util;

use ImpartialPipes\LazyRewindableIterator;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\iterable_count;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;

/**
 * @internal
 */
final class iterable_count_Test extends UnitTestCase
{
    public function test_iterable_count(): void
    {
        pipe(iterable_count([]))
        ->to(p_assert_equals(0));

        pipe(iterable_count([1,2]))
        ->to(p_assert_equals(2));

        pipe(iterable_count(new SimpleIterator([1,2,3])))
        ->to(p_assert_equals(3));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIterator([1,2,3,4]))))
        ->to(p_assert_equals(4));

        pipe(iterable_count(new UniterableArrayIterator([1,2,3,4,5])))
        ->to(p_assert_equals(5));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new UniterableArrayIterator([1,2,3,4,5,6]))))
        ->to(p_assert_equals(6));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7]))))
        ->to(p_assert_equals(7));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8])))))
        ->to(p_assert_equals(8));

        pipe(iterable_count(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9]))))
        ->to(p_assert_equals(9));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10])))))
        ->to(p_assert_equals(10));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11])))))
        ->to(p_assert_equals(11));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11,12]))))))
        ->to(p_assert_equals(12));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13])))))
        ->to(p_assert_equals(13));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13,14]))))))
        ->to(p_assert_equals(14));
    }
}
