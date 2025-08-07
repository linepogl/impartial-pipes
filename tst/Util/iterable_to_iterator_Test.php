<?php

declare(strict_types=1);

namespace Tests\Util;

use ArrayIterator;
use IteratorAggregate;
use Override;
use Tests\UnitTestCase;
use Traversable;

use function ImpartialPipes\iterable_to_iterator;

/**
 * @internal
 */
final class iterable_to_iterator_Test extends UnitTestCase
{
    public function test_iterable_to_iterator(): void
    {
        $this->expect(iterable_to_iterator([1, 2, 3]))->toBeInstanceOf(ArrayIterator::class);
        $this->expect(iterable_to_iterator(new ArrayIterator([1, 2, 3])))->toBeInstanceOf(ArrayIterator::class);
        $this->expect(iterable_to_iterator(
            new class () implements IteratorAggregate {
                #[Override]
                public function getIterator(): Traversable
                {
                    return new ArrayIterator([1, 2, 3]);
                }
            },
        ))->toBeInstanceOf(ArrayIterator::class);
    }
}
