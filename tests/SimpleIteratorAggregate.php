<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests;

use Iterator;
use IteratorAggregate;
use Override;
use Traversable;

/**
 * @internal
 * @template K
 * @template V
 * @implements IteratorAggregate<K, V>
 */
final class SimpleIteratorAggregate implements IteratorAggregate
{
    public function __construct(
        private readonly Iterator|IteratorAggregate $it,
    ) {
    }

    #[Override]
    public function getIterator(): Traversable
    {
        return $this->it;
    }
}
