<?php

declare(strict_types=1);

namespace Tests\Util;

use ArrayIterator;
use IteratorAggregate;
use Override;
use PHPUnit\Framework\TestCase;
use Tests\UniterableArrayIterator;
use Traversable;

use function ImpartialPipes\iterable_to_iterator;
use function ImpartialPipes\pipe;
use function Tests\shouldBeA;

/**
 * @internal
 */
final class iterable_to_iterator_Test extends TestCase
{
    public function test_iterable_to_iterator(): void
    {
        pipe(iterable_to_iterator([1, 2, 3]))
        ->to(shouldBeA(ArrayIterator::class));

        pipe(iterable_to_iterator(new UniterableArrayIterator([1, 2, 3])))
        ->to(shouldBeA(UniterableArrayIterator::class));

        pipe(iterable_to_iterator(
            new class () implements IteratorAggregate {
                #[Override]
                public function getIterator(): Traversable
                {
                    return new UniterableArrayIterator([1, 2, 3]);
                }
            },
        ))->to(shouldBeA(UniterableArrayIterator::class));
    }
}
