<?php

declare(strict_types=1);

namespace Tests\Util;

use ImpartialPipes\LazyRewindableIterator;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\iterable_count;

/**
 * @internal
 */
final class iterable_count_Test extends UnitTestCase
{
    public function test_iterable_count(): void
    {
        $this
            ->expect(iterable_count([]))
            ->toBe(0);
        $this
            ->expect(iterable_count([1,2]))
            ->toBe(2);
        $this
            ->expect(iterable_count(new SimpleIterator([1,2,3])))
            ->toBe(3);
        $this
            ->expect(iterable_count(new LazyRewindableIterator(fn () => new SimpleIterator([1,2,3,4]))))
            ->toBe(4);
        $this
            ->expect(iterable_count(new UniterableArrayIterator([1,2,3,4,5])))
            ->toBe(5);
        $this
            ->expect(iterable_count(new LazyRewindableIterator(fn () => new UniterableArrayIterator([1,2,3,4,5,6]))))
            ->toBe(6);
        $this
            ->expect(iterable_count(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7]))))
            ->toBe(7);
        $this
            ->expect(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8])))))
            ->toBe(8);
        $this
            ->expect(iterable_count(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9]))))
            ->toBe(9);
        $this
            ->expect(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10])))))
            ->toBe(10);
        $this
            ->expect(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11])))))
            ->toBe(11);
        $this
            ->expect(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11,12]))))))
            ->toBe(12);
        $this
            ->expect(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13])))))
            ->toBe(13);
        $this
            ->expect(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13,14]))))))
            ->toBe(14);
    }
}
