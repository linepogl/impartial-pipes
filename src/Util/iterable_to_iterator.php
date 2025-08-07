<?php

declare(strict_types=1);

namespace ImpartialPipes;

use ArrayIterator;
use Iterator;
use IteratorAggregate;
use IteratorIterator;

/**
 * @template K
 * @template V
 * @param iterable<K,V>|callable():iterable<K,V> $input
 * @return Iterator<K,V>
 */
function iterable_to_iterator(iterable|callable $input): Iterator
{
    return match(true) {
        is_array($input) => new ArrayIterator($input), // @phpstan-ignore argument.type (since $input is an array, the $key is always array-key)
        $input instanceof Iterator => $input,
        $input instanceof IteratorAggregate => iterable_to_iterator($input->getIterator()),
        is_callable($input) => new LazyRewindableIterator($input),

        /** @codeCoverageIgnore (we have already coverred all cases of iterable: array|Iterator|IteragtorAggregate, the default case cannot be reached or tested) */
        default => new IteratorIterator($input),
    };
}
