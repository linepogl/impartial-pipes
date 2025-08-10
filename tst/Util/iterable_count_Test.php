<?php

declare(strict_types=1);

namespace Tests\Util;

use ImpartialPipes\LazyRewindableIterator;
use PHPUnit\Framework\TestCase;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\iterable_count;
use function ImpartialPipes\pipe;
use function Tests\shouldBe;

/**
 * @internal
 */
final class iterable_count_Test extends TestCase
{
    public function test_iterable_count(): void
    {
        pipe(iterable_count([]))
        ->to(shouldBe(0));

        pipe(iterable_count([1,2]))
        ->to(shouldBe(2));

        pipe(iterable_count(new SimpleIterator([1,2,3])))
        ->to(shouldBe(3));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIterator([1,2,3,4]))))
        ->to(shouldBe(4));

        pipe(iterable_count(new UniterableArrayIterator([1,2,3,4,5])))
        ->to(shouldBe(5));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new UniterableArrayIterator([1,2,3,4,5,6]))))
        ->to(shouldBe(6));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7]))))
        ->to(shouldBe(7));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8])))))
        ->to(shouldBe(8));

        pipe(iterable_count(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9]))))
        ->to(shouldBe(9));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10])))))
        ->to(shouldBe(10));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11])))))
        ->to(shouldBe(11));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11,12]))))))
        ->to(shouldBe(12));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13])))))
        ->to(shouldBe(13));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13,14]))))))
        ->to(shouldBe(14));
    }
}
