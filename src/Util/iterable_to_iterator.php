<?php

declare(strict_types=1);

namespace Pipes\Util;

use ArrayIterator;
use Iterator;
use IteratorAggregate;
use IteratorIterator;

/**
 * @template K
 * @template V
 * @param iterable<K,V> $input
 * @return Iterator<K,V>
 */
function iterable_to_iterator(iterable $input): Iterator
{
    return match(true) {
        is_array($input) => new ArrayIterator($input),
        $input instanceof Iterator => $input,
        $input instanceof IteratorAggregate => iterable_to_iterator($input->getIterator()),
        is_callable($input) => new LazyRewindableIterator($input),
        default => new IteratorIterator($input),
    };
}
