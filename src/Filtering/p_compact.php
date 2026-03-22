<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that filters null values out of an iterable.
 *
 * ### Syntax
 * ```
 * p_compact()
 * ```
 *
 * ### Examples
 * Filter out nulls
 * ```
 * [1, 2, null, 3]
 * |> p_compact()
 * //= [1, 2, 3]
 * ```
 *
 * @return callable<K,V>(iterable<K,V>):iterable<int,V>
 */
function p_compact(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $value) {
            if (null !== $value) {
                yield $value;
            }
        }
    });
}

/**
 * Returns a partial function that filters null values out of an iterable, preserving the keys.
 *
 * ### Syntax
 * ```
 * p_assoc_compact()
 * ```
 *
 * ### Examples
 * Filter out nulls
 * ```
 * ['a' => 1, 'b' => null, 'c' => 3]
 * |> p_assoc_compact(preserveKeys: true)
 * //= ['a' => 1, 'c' => 3]
 * ```
 *
 * @return callable<K,V>(iterable<K,V>):iterable<K,V>
 */
function p_assoc_compact(): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
        foreach ($iterable as $key => $value) {
            if (null !== $value) {
                yield $key => $value;
            }
        }
    });
}
