<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Countable;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;

/**
 * @template K
 * @template V
 * @param iterable<K,V> $iterable
 * @return int<0,max>
 */
function iterable_count(iterable $iterable): int
{
    return match(true) {
        is_array($iterable) => count($iterable),
        $iterable instanceof Countable => $iterable->count(),
        $iterable instanceof Iterator => iterator_count($iterable),
        $iterable instanceof IteratorAggregate => iterable_count($iterable->getIterator()),

        /** @codeCoverageIgnore (we have already coverred all cases of iterable: array|Iterator|IteragtorAggregate, the default case cannot be reached or tested) */
        default => throw new InvalidArgumentException('Invalid input type: ' . get_debug_type($iterable)),
    };
}
