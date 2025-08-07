<?php

declare(strict_types=1);

namespace ImpartialPipes;

use ArrayIterator;

/**
 * @return callable<K of array-key,V>(iterable<K, V>):array<K,V>
 */
function p_to_array(): callable
{
    // @phpstan-ignore return.type (iterator_to_array has an incomplete signature)
    return static fn (iterable $iterable) => match(true) {
        $iterable instanceof ArrayIterator => $iterable->getArrayCopy(),
        default => iterator_to_array($iterable, preserve_keys: true),
    };
}
