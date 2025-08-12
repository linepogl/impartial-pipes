<?php

declare(strict_types=1);

namespace Tests\Reducing;

use Countable;
use ImpartialPipes\LazyRewindableIterator;
use Override;
use PHPUnit\Framework\TestCase;
use Tests\SimpleIterator;
use Tests\SimpleIteratorAggregate;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\p_count;
use function ImpartialPipes\pipe;
use function Should\shouldBe;

/**
 * @internal
 */
final class p_count_Test extends TestCase
{
    public function test_p_count(): void
    {
        pipe([])
        ->to(p_count())
        ->to(shouldBe(0));

        pipe([1,2])
        ->to(p_count())
        ->to(shouldBe(2));

        pipe(new SimpleIterator([1,2,3]))
        ->to(p_count())
        ->to(shouldBe(3));

        pipe(new LazyRewindableIterator(fn () => new SimpleIterator([1,2,3,4])))
        ->to(p_count())
        ->to(shouldBe(4));

        pipe(new UniterableArrayIterator([1,2,3,4,5]))
        ->to(p_count())
        ->to(shouldBe(5));

        pipe(new LazyRewindableIterator(fn () => new UniterableArrayIterator([1,2,3,4,5,6])))
        ->to(p_count())
        ->to(shouldBe(6));

        pipe(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7])))
        ->to(p_count())
        ->to(shouldBe(7));

        pipe(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8]))))
        ->to(p_count())
        ->to(shouldBe(8));

        pipe(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9])))
        ->to(p_count())
        ->to(shouldBe(9));

        pipe(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10]))))
        ->to(p_count())
        ->to(shouldBe(10));

        pipe(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11]))))
        ->to(p_count())
        ->to(shouldBe(11));

        pipe(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new SimpleIterator([1,2,3,4,5,6,7,8,9,10,11,12])))))
        ->to(p_count())
        ->to(shouldBe(12));

        pipe(new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13]))))
        ->to(p_count())
        ->to(shouldBe(13));

        pipe(new LazyRewindableIterator(fn () => new SimpleIteratorAggregate(new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4,5,6,7,8,9,10,11,12,13,14])))))
        ->to(p_count())
        ->to(shouldBe(14));
    }

    public function test_p_count_with_countables(): void
    {
        pipe(new class () implements Countable {
            #[Override]
            public function count(): int
            {
                return 5;
            }
        })->to(p_count())
        ->to(shouldBe(5));
    }

    public function test_p_count_with_a_predicate(): void
    {
        pipe([])
        ->to(p_count(fn (int $x) => $x % 2 === 0))
        ->to(shouldBe(0));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_count(fn (int $x) => $x % 2 === 0))
        ->to(shouldBe(2));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_count(fn (int $x, string $k) => $k === 'b'))
        ->to(shouldBe(1));
    }
}
