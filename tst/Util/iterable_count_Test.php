<?php

declare(strict_types=1);

namespace Tests\Util;

use ImpartialPipes\LazyRewindableIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\iterable_count;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class iterable_count_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_iterable_count(): void
    {
        pipe(iterable_count([]))
        ->to(self::is(0));

        pipe(iterable_count([1,2]))
        ->to(self::is(2));

        pipe(iterable_count(new SimpleIterator([1,2,3])))
        ->to(self::is(3));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIterator([1,2,3,4]))))
        ->to(self::is(4));

        pipe(iterable_count(new UniterableArrayIterator([1,2,3,4,5])))
        ->to(self::is(5));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new UniterableArrayIterator([1,2,3,4,5,6]))))
        ->to(self::is(6));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7]))))
        ->to(self::is(7));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8])))))
        ->to(self::is(8));

        pipe(iterable_count(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9]))))
        ->to(self::is(9));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10])))))
        ->to(self::is(10));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11])))))
        ->to(self::is(11));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11,12]))))))
        ->to(self::is(12));

        pipe(iterable_count(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13])))))
        ->to(self::is(13));

        pipe(iterable_count(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13,14]))))))
        ->to(self::is(14));
    }
}
