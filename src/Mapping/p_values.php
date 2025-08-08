<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to map to the values of an iterable.
 *
 * ### Syntax
 *
 * ```
 * p_values()
 * ```
 *
 * ### Examples
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_values()
 * //= [1, 2]
 * ```
 *
 * @return callable<K,V>(iterable<K, V>):iterable<int, V>
 */
function p_values(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $value) {
            yield $value;
        }
    });
}
