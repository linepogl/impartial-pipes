<?php

declare(strict_types=1);

namespace Tests\Util;

use ArrayIterator;
use IteratorAggregate;
use Override;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;
use Traversable;

use function ImpartialPipes\iterable_to_iterator;
use function Tests\p_assert_instance_of;
use function Tests\pipe;

/**
 * @internal
 */
final class iterable_to_iterator_Test extends UnitTestCase
{
    public function test_iterable_to_iterator(): void
    {
        pipe(iterable_to_iterator([1, 2, 3]))
        ->to(p_assert_instance_of(ArrayIterator::class));

        pipe(iterable_to_iterator(new UniterableArrayIterator([1, 2, 3])))
        ->to(p_assert_instance_of(UniterableArrayIterator::class));

        pipe(iterable_to_iterator(
            new class () implements IteratorAggregate {
                #[Override]
                public function getIterator(): Traversable
                {
                    return new UniterableArrayIterator([1, 2, 3]);
                }
            },
        ))->to(p_assert_instance_of(UniterableArrayIterator::class));
    }
}
