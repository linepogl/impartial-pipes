<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Countable;
use ImpartialPipes\LazyRewindableIterator;
use Override;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_count;

/**
 * @internal
 */
final class p_count_Test extends UnitTestCase
{
    public function test_p_count(): void
    {
        $this
            ->expect([])
            ->pipe(p_count())
            ->toBe(0);
        $this
            ->expect([1,2])
            ->pipe(p_count())
            ->toBe(2);
        $this
            ->expect(new SimpleIterator([1,2,3]))
            ->pipe(p_count())
            ->toBe(3);
        $this
            ->expect(new LazyRewindableIterator(fn () => new SimpleIterator([1,2,3,4])))
            ->pipe(p_count())
            ->toBe(4);
        $this
            ->expect(new UniterableArrayIterator([1,2,3,4,5]))
            ->pipe(p_count())
            ->toBe(5);
        $this
            ->expect(new LazyRewindableIterator(fn () => new UniterableArrayIterator([1,2,3,4,5,6])))
            ->pipe(p_count())
            ->toBe(6);
        $this
            ->expect(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7])))
            ->pipe(p_count())
            ->toBe(7);
        $this
            ->expect(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8]))))
            ->pipe(p_count())
            ->toBe(8);
        $this
            ->expect(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9])))
            ->pipe(p_count())
            ->toBe(9);
        $this
            ->expect(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10]))))
            ->pipe(p_count())
            ->toBe(10);
        $this
            ->expect(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11]))))
            ->pipe(p_count())
            ->toBe(11);
        $this
            ->expect(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11,12])))))
            ->pipe(p_count())
            ->toBe(12);
        $this
            ->expect(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13]))))
            ->pipe(p_count())
            ->toBe(13);
        $this
            ->expect(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13,14])))))
            ->pipe(p_count())
            ->toBe(14);
    }

    public function test_p_count_with_countables(): void
    {
        $this
            ->expect(new class () implements Countable {
                #[Override]
                public function count(): int
                {
                    return 5;
                }
            })
            ->pipe(p_count())
            ->toBe(5);
    }
}
