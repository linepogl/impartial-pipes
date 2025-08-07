<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use ImpartialPipes\LazyRewindableIterator;
use Override;
use RuntimeException;
use Tests\UnitTestCase;

use function ImpartialPipes\p_count;

/**
 * @internal
 */
final class p_count_Test extends UnitTestCase
{
    public function test_p_all_with_arrays(): void
    {
        $this
            ->expect([])
            ->pipe(p_count())
            ->toBe(0);

        $this
            ->expect([1,2,3])
            ->pipe(p_count())
            ->toBe(3);
    }

    public function test_p_all_with_array_iterators(): void
    {
        $it = new class ([1,2,3]) extends ArrayIterator {
            #[Override]
            public function rewind(): void
            {
                throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
            }
            #[Override]
            public function next(): void
            {
                throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
            }
            #[Override]
            public function key(): null|int|string
            {
                throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
            }
            #[Override]
            public function current(): mixed
            {
                throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
            }
            #[Override]
            public function valid(): bool
            {
                throw new RuntimeException('Counting arrays should happen in O(1) without iterating.');
            }
        };

        $this
            ->expect($it)
            ->pipe(p_count())
            ->toBe(3);

        $this->expect(new LazyRewindableIterator(fn () => $it))
            ->pipe(p_count())
            ->toBe(3);
    }
}
