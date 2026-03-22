<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * Returns a partial function that maps the values of an iterable using a projection.
 *
 * ### Syntax
 *
 * ```
 * p_map(
 *   callable(TValue[, TKey]): TNewValue,
 * )
 * ```
 *
 * ### Examples
 *
 * Map by value
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_map(static fn (int $value) => $value * $value)
 * //= [1, 4]
 * ```
 *
 * Map by value and key
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_map(static fn (int $value, string $key) => $key . $value)
 * //= ['a1', 'b2']
 * ```
 *
 * @template K
 * @template V
 * @template V2
 * @param callable(V,K):V2 $valueProjection
 * @return callable(iterable<K,V>):iterable<int,V2>
 */
function p_map(callable $valueProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection): iterable {
        foreach ($iterable as $key => $value) {
            yield $valueProjection($value, $key);
        }
    });
}

/**
 * Returns a partial function that maps the values of an iterable using a projection, preserving the keys.
 *
 * ### Syntax
 *
 * ```
 * p_assoc_map(
 *   callable(TValue[, TKey]): TNewValue,
 * )
 * ```
 *
 * ### Examples
 *
 * Map by value
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_assoc_map(static fn (int $value) => $value * $value)
 * //= ['a' => 1, 'b' => 4]
 * ```
 *
 * Map by value and key
 * ```
 * ['a' => 1, 'b' => 2]
 * |> p_assoc_map(static fn (int $value, string $key) => $key . $value)
 * //= ['a' => 'a1', 'b' => 'b2']
 * ```
 *
 * @template K
 * @template V
 * @template V2
 * @param callable(V,K):V2 $valueProjection
 * @return callable(iterable<K,V>):iterable<K,V2>
 */
function p_assoc_map(callable $valueProjection): callable
{
    return static fn (iterable $iterable): iterable => new LazyRewindableIterator(static function () use ($iterable, $valueProjection): iterable {
        foreach ($iterable as $key => $value) {
            yield $key => $valueProjection($value, $key);
        }
    });
}
