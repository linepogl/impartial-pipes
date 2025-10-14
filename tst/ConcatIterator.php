<?php

declare(strict_types=1);

namespace Tests;

use ImpartialPipes\LazyRewindableIterator;
use IteratorAggregate;
use Override;
use Traversable;

/**
 * @internal
 * @template K
 * @template V
 * @implements IteratorAggregate<K,V>
 */
final class ConcatIterator implements IteratorAggregate
{
    /** @var array<iterable<K,V>> */
    private readonly array $iterables;

    /**
     * @param iterable<K,V> ...$iterables
     */
    public function __construct(
        iterable ...$iterables,
    ) {
        $this->iterables = $iterables;
    }

    #[Override]
    public function getIterator(): Traversable
    {
        return new LazyRewindableIterator(function () {
            foreach ($this->iterables as $iterable) {
                foreach ($iterable as $key => $value) {
                    yield $key => $value;
                }
            }
        });
    }
}
