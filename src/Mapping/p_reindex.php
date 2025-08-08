<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Partial function to map the keys of an iterable using a projection. It preserves the values.
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
 * //= [1 => 1, 4 => 2], the key 4 is skipped the second time
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
 * //= [1 => 1, 2 => 2], the key 2 is skipped the second time
 * ```
 *
 * @template K
 * @template V
 * @template K2 of array-key
 * @param callable(V,K):K2 $keyProjection
 * @return callable(iterable<K,V>):iterable<K2,V>
 */
function p_reindex(callable $keyProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $keyProjection): iterable {
        $seen = [];
        foreach ($iterable as $key => $value) {
            $newKey = $keyProjection($value, $key);
            if (array_key_exists($newKey, $seen)) {
                continue;
            }
            $seen[$newKey] = true;
            yield $newKey => $value;
        }
    });
}
