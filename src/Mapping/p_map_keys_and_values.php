<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that maps the keys and the values of an iterable using two projections simultaneously.
 *
 * Attention: it is possible to have repeated keys in the result, use u_unique_keys to eliminate them.
 *
 * ### Syntax
 *
 * ```
 * p_map_keys_and_values(
 *   callable(TValue[, TKey]): TNewKey,
 *   callable(TValue[, TKey]): TNewValue,
 * )
 * ```
 *
 * ### Examples
 * Map keys and values by value projections
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 3]
 * |> p_map_keys_and_values(
 *   static fn (int $value) => $value * $value,
 *   static fn (int $value) => $value * $value,
 * )
 * //= [1 => 1, 4 => 4, 9 => 9]
 * ```
 * ```
 * ['a' => 1, 'b' => 2, 'c' => 2]
 * |> p_map_keys_and_values(
 *   static fn (int $value) => $value * $value,
 *   static fn (int $value) => $value * $value,
 * )
 * //= [1 => 1, 4 => 4, 4 => 4], the key 4 is repeated, use u_unique_keys to eliminate it
 * ```
 * Map keys and values by value and key projections
 * ```
 * ['a' => 0, 'bb' => 0, 'ccc' => 0]
 * |> p_map_keys_and_values(
 *   static fn (int $value, string $key) => strlen($key),
 *   static fn (int $value, string $key) => strlen($key),
 * )
 * //= [1 => 1, 2 => 2, 3 => 3]
 * ```
 * ```
 * ['a' => 0, 'bb' => 0, 'cc' => 0]
 * |> p_map_keys_and_values(
 *   static fn (int $value, string $key) => strlen($key),
 *   static fn (int $value, string $key) => strlen($key),
 * )
 * //= [1 => 1, 2 => 2, 2 => 2], the key 2 is repeated, use u_unique_keys to eliminate it
 * ```
 *
 * @template K
 * @template V
 * @template K2
 * @template V2
 * @param callable(V,K):K2 $keyProjection
 * @param callable(V,K):V2 $valueProjection
 * @return callable(iterable<K,V>):iterable<K2,V2>
 */
function p_map_keys_and_values(callable $keyProjection, callable $valueProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $keyProjection, $valueProjection): iterable {
        foreach ($iterable as $key => $value) {
            yield $keyProjection($value, $key) => $valueProjection($value, $key);
        }
    });
}
