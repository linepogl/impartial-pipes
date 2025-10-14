<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that maps the keys of an iterable using a projection. It preserves the values.
 *
 * If the projection returns a key that already exists in the iterable, the value is skipped.
 *
 * ### Syntax
 *
 * ```
 * p_reindex(
 *   callable(TValue[, TKey]): TNewKey of array-key,
 * )
 * ```
 *
 * ### Examples
 * Reindex by value projection
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3]
 * |> p_reindex(static fn (int $value) => $value * $value)
 * //= [1 => 1, 4 => 2, 9 => 3]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 2]
 * |> p_reindex(static fn (int $value) => $value * $value)
 * //= [1 => 1, 4 => 2, 4 => 4], the key 4 is repeated, use u_unique_keys to eliminate it
 * ```
 * ReIndex by value and key projection
 * ```
 * ['a' => 1, 'bb' => 2, 'ccc' => 3]
 * |> p_reindex(static fn (int $value, string $key) => strlen($key))
 * //= [1 => 1, 2 => 2, 3 => 3]
 * ```
 * ```
 * ['a' => 1, 'bb' => 2, 'cc' => 3]
 * |> p_reindex(static fn (int $value, string $key) => strlen($key))
 * //= [1 => 1, 2 => 2, 2 => 3], the key 2 is repeated, use u_unique_keys to eliminate it
 * ```
 *
 * @template K
 * @template V
 * @template K2
 * @param callable(V,K):K2 $keyProjection
 * @return callable(iterable<K,V>):iterable<K2,V>
 */
function p_reindex(callable $keyProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $keyProjection): iterable {
        foreach ($iterable as $key => $value) {
            yield $keyProjection($value, $key) => $value;
        }
    });
}
