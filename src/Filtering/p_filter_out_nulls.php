<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to filter out null values of an iterable.
 *
 * ### Examples
 *
 * ```
 * [1, 2, null, 3]
 * |> p_filter_out_nulls()
 * //= [1, 2, 3]
 * ```
 * ```
 * ['a' => 1, 'b' => null, 'c' => 3]
 * |> p_filter_out_nulls(preserveKeys: true)
 * //= ['a' => 1, 'c' => 3]
 * ```
 *
 * @param bool $preserveKeys
 * @return ($preserveKeys is true ? callable<K,V>(iterable<K,V>):iterable<K,V> : callable<K,V>(iterable<K,V>):iterable<int,V>)
 */
function p_filter_out_nulls(bool $preserveKeys = false): callable
{
    return $preserveKeys
        ? static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
            foreach ($iterable as $key => $value) {
                if (null !== $value) {
                    yield $key => $value;
                }
            }
        })
        : static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable): iterable {
            foreach ($iterable as $value) {
                if (null !== $value) {
                    yield $value;
                }
            }
        });
}
