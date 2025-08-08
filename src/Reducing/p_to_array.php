<?php

declare(strict_types=1);

namespace ImpartialPipes;

use ArrayIterator;

/**
 * Partial function to evaluate an iterable into an array.
 *
 * ### Syntax
 * ```
 * p_to_array()
 * ```
 *
 * ### Examples
 * ```
 * []
 * |> p_to_array()
 * //= []
 * ```
 * ```
 * [1, 2, 3]
 * |> p_to_array()
 * //= [1, 2, 3]
 * ```
 *
 * @return callable<K of array-key,V>(iterable<K, V>):array<K,V>
 */
function p_to_array(): callable
{
    // @phpstan-ignore return.type (iterator_to_array has an incomplete signature)
    return static fn (iterable $iterable) => match(true) {
        is_array($iterable) => $iterable,
        $iterable instanceof ArrayIterator => $iterable->getArrayCopy(),
        default => iterator_to_array($iterable, preserve_keys: true),
    };
}
